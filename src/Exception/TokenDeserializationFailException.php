<?php
/**
 * Created by PhpStorm.
 * User: omni
 * Date: 13.11.2018
 * Time: 20:34
 */

namespace Umbrella\AFCTokenBundle\Exception;

/**
 * Class TokenDeserializationFailException
 *
 * @package Umbrella\AFCTokenBundle\Exception
 */
class TokenDeserializationFailException extends AFCTokenException
{
	const MESSAGE = "Token deserialization failed.";

	/**
	 * TokenDeserializationFailException constructor.
	 *
	 * @param string          $message
	 * @param int             $code
	 * @param null|\Throwable $previous
	 */
	public function __construct(string $message = "", int $code = 0, ?\Throwable $previous = NULL) {

		$message = $message ? static::MESSAGE . '(reason: '. $message .')' : static::MESSAGE;

		parent::__construct($message, $code, $previous);
	}
}