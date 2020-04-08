<?php

namespace AFCTokenBundle\Utils;

use Firebase\JWT\BeforeValidException;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\SignatureInvalidException;
use AFCTokenBundle\Exception\TokenConstructorFailException;
use AFCTokenBundle\Entity\RefreshTokenHash;
use AFCTokenBundle\Entity\Token;
use AFCTokenBundle\Exception\DeserializationFailException;
use AFCTokenBundle\TokenInterface;
use JCLibPack\JCDateTime;
use JCLibPack\JCEncrypter;
use UnexpectedValueException;

/**
 * Class JWTTokenSerializer
 *
 * @package AFCTokenBundle\Service
 */
class JWTTokenSerializer
{
	private const TYPE = 'HS512';

	/**
	 * @param \AFCTokenBundle\TokenInterface $Token
	 * @param string|NULL                             $privateKey
	 * @return array
	 */
	static public function ArraySerialize(TokenInterface $Token, string $privateKey = null) :array{

		return [
			'exp'       => (clone $Token->getAt())->modify('+'. $Token->getTtl() . ' seconds')->getTimestamp(),
			'salt'      => $Token->getSalt(),
			'shared'    => $Token->getSharedData(),
			'crypt'     => JCEncrypter::encrypt_RSA(json_encode($Token->getEncryptedData()), $privateKey),
			'refresh'   => $Token->getRefreshHash(),
		];
	}

	/**
	 * !Key must be in .pem format
	 * @param \AFCTokenBundle\TokenInterface $Token
	 * @param string                             $secret
	 * @param string                             $privateKey
	 * @return string
	 */
	static public function serialize(TokenInterface $Token, string $secret, string $privateKey): string {

		$jwt = JWT::encode(static::ArraySerialize($Token, $privateKey), $secret, static::TYPE);

		return $jwt;
	}

	/**
	 * !Key must be in .pem format
	 *
	 * @param string $tokenString
	 * @param string $secret
	 * @param string $publicKey
	 * @return \AFCTokenBundle\TokenInterface
	 *
	 * @throws \AFCTokenBundle\Exception\DeserializationFailException
	 */
	static public function deserialize(string $tokenString, string $secret, string $publicKey): TokenInterface
	{
		try {
			$tokenData = JWT::decode($tokenString, $secret, [static::TYPE], false);

			$decryptedData = json_decode(JCEncrypter::decrypt_RSA($tokenData->crypt, $publicKey));

			$Token = new Token(
				$decryptedData->resource,
				$decryptedData->ttl,
				new RefreshTokenHash($tokenData->refresh)
			);

			$Token->setAt(JCDateTime::import(
				new \DateTime($decryptedData->at->date, new \DateTimeZone($decryptedData->at->timezone))
			)
			);
			$Token->setSalt($tokenData->salt);

			return $Token;

		}catch (
		TokenConstructorFailException|
		UnexpectedValueException|
		SignatureInvalidException
		$Exception){
			throw new DeserializationFailException($Exception->getMessage(), 0, $Exception);
		}
	}
}