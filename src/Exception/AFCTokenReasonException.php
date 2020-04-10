<?php

namespace Aimchat\AFCTokenBundle\Exception;

/**
 * Class AFCTokenReasonException
 *
 * @package Aimchat\AFCTokenBundle\Exception
 */
abstract class AFCTokenReasonException extends AFCTokenException
{
	const MESSAGE = 'Unexpected exception';

	/**
	 * AFCTokenReasonException constructor.
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