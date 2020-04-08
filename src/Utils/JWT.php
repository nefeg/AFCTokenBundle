<?php

namespace AFCTokenBundle\Utils;

use DomainException;
use Firebase\JWT\BeforeValidException;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\SignatureInvalidException;
use \InvalidArgumentException;
use \UnexpectedValueException;

/**
 * Class JWT
 *
 * @package AFCTokenBundle\Utils
 */
class JWT extends \Firebase\JWT\JWT
{
	/**
	 * Decodes a JWT string into a PHP object.
	 *
	 * @param string        $jwt            The JWT
	 * @param string|array  $key            The key, or map of keys.
	 *                                      If the algorithm used is asymmetric, this is the public key
	 * @param array         $allowed_algs   List of supported verification algorithms
	 *                                      Supported algorithms are 'HS256', 'HS384', 'HS512' and 'RS256'
	 * @param bool         $validateFields

	 *
	 * @return object The JWT's payload as a PHP object
	 *
	 * @throws UnexpectedValueException     Provided JWT was invalid
	 * @throws SignatureInvalidException    Provided JWT was invalid because the signature verification failed
	 * @throws BeforeValidException         Provided JWT is trying to be used before it's eligible as defined by 'nbf'
	 * @throws BeforeValidException         Provided JWT is trying to be used before it's been created as defined by 'iat'
	 * @throws ExpiredException             Provided JWT has since expired, as defined by the 'exp' claim
	 *
	 * @uses jsonDecode
	 * @uses urlsafeB64Decode
	 */
	public static function decode($jwt, $key, array $allowed_algs = [], $validateFields = true) {

		if (empty($key)) {
			throw new InvalidArgumentException('Key may not be empty');
		}
		$tks = explode('.', $jwt);
		if (count($tks) != 3) {
			throw new UnexpectedValueException('Wrong number of segments');
		}
		list($headb64, $bodyb64, $cryptob64) = $tks;
		if (null === ($header = static::jsonDecode(static::urlsafeB64Decode($headb64)))) {
			throw new UnexpectedValueException('Invalid header encoding');
		}
		if (null === $payload = static::jsonDecode(static::urlsafeB64Decode($bodyb64))) {
			throw new UnexpectedValueException('Invalid claims encoding');
		}
		if (false === ($sig = static::urlsafeB64Decode($cryptob64))) {
			throw new UnexpectedValueException('Invalid signature encoding');
		}
		if (empty($header->alg)) {
			throw new UnexpectedValueException('Empty algorithm');
		}
		if (empty(static::$supported_algs[$header->alg])) {
			throw new UnexpectedValueException('Algorithm not supported');
		}
		if (!in_array($header->alg, $allowed_algs)) {
			throw new UnexpectedValueException('Algorithm not allowed');
		}
		if (is_array($key) || $key instanceof \ArrayAccess) {
			if (isset($header->kid)) {
				if (!isset($key[$header->kid])) {
					throw new UnexpectedValueException('"kid" invalid, unable to lookup correct key');
				}
				$key = $key[$header->kid];
			} else {
				throw new UnexpectedValueException('"kid" empty, unable to lookup correct key');
			}
		}

		// Check the signature
		if (!static::verify("$headb64.$bodyb64", $sig, $key, $header->alg)) {
			throw new SignatureInvalidException('Signature verification failed');
		}


		if ($validateFields){
			static::validateFields($payload);
		}

		return $payload;
	}

	/**
	 * @param $payload
	 * @throws BeforeValidException         Provided JWT is trying to be used before it's eligible as defined by 'nbf'
	 * @throws BeforeValidException         Provided JWT is trying to be used before it's been created as defined by 'iat'
	 * @throws ExpiredException             Provided JWT has since expired, as defined by the 'exp' claim
	 */
	static public function validateFields($payload) :void
	{
		$timestamp = is_null(static::$timestamp) ? time() : static::$timestamp;

		// Check if the nbf if it is defined. This is the time that the
		// token can actually be used. If it's not yet that time, abort.
		if (isset($payload->nbf) && $payload->nbf > ($timestamp + static::$leeway)) {
			throw new BeforeValidException(
				'Cannot handle token prior to ' . date(\DateTime::ISO8601, $payload->nbf)
			);
		}

		// Check that this token has been created before 'now'. This prevents
		// using tokens that have been created for later use (and haven't
		// correctly used the nbf claim).
		if (isset($payload->iat) && $payload->iat > ($timestamp + static::$leeway)) {
			throw new BeforeValidException(
				'Cannot handle token prior to ' . date(\DateTime::ISO8601, $payload->iat)
			);
		}

		// Check if this token has expired.
		if (isset($payload->exp) && ($timestamp - static::$leeway) >= $payload->exp) {
			throw new ExpiredException('Expired token');
		}
	}



	/**
	 * Verify a signature with the message, key and method. Not all methods
	 * are symmetric, so we must have a separate verify and sign method.
	 *
	 * @param string            $msg        The original message (header and body)
	 * @param string            $signature  The original signature
	 * @param string|resource   $key        For HS*, a string key works. for RS*, must be a resource of an openssl public key
	 * @param string            $alg        The algorithm
	 *
	 * @return bool
	 *
	 * @throws DomainException Invalid Algorithm or OpenSSL failure
	 */
	private static function verify($msg, $signature, $key, $alg)
	{
		if (empty(static::$supported_algs[$alg])) {
			throw new DomainException('Algorithm not supported');
		}

		list($function, $algorithm) = static::$supported_algs[$alg];
		switch($function) {
			case 'openssl':
				$success = openssl_verify($msg, $signature, $key, $algorithm);
				if ($success === 1) {
					return true;
				} elseif ($success === 0) {
					return false;
				}
				// returns 1 on success, 0 on failure, -1 on error.
				throw new DomainException(
					'OpenSSL error: ' . openssl_error_string()
				);
			case 'hash_hmac':
			default:
				$hash = hash_hmac($algorithm, $msg, $key, true);
				if (function_exists('hash_equals')) {
					return hash_equals($signature, $hash);
				}
				$len = min(static::safeStrlen($signature), static::safeStrlen($hash));

				$status = 0;
				for ($i = 0; $i < $len; $i++) {
					$status |= (ord($signature[$i]) ^ ord($hash[$i]));
				}
				$status |= (static::safeStrlen($signature) ^ static::safeStrlen($hash));

				return ($status === 0);
		}
	}

	/**
	 * Helper method to create a JSON error.
	 *
	 * @param int $errno An error number from json_last_error()
	 *
	 * @return void
	 */
	private static function handleJsonError($errno)
	{
		$messages = array(
			JSON_ERROR_DEPTH => 'Maximum stack depth exceeded',
			JSON_ERROR_STATE_MISMATCH => 'Invalid or malformed JSON',
			JSON_ERROR_CTRL_CHAR => 'Unexpected control character found',
			JSON_ERROR_SYNTAX => 'Syntax error, malformed JSON',
			JSON_ERROR_UTF8 => 'Malformed UTF-8 characters' //PHP >= 5.3.3
		);
		throw new DomainException(
			isset($messages[$errno])
				? $messages[$errno]
				: 'Unknown JSON error: ' . $errno
		);
	}

	/**
	 * Get the number of bytes in cryptographic strings.
	 *
	 * @param string
	 *
	 * @return int
	 */
	private static function safeStrlen($str)
	{
		if (function_exists('mb_strlen')) {
			return mb_strlen($str, '8bit');
		}
		return strlen($str);
	}
}