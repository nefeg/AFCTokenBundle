<?php

namespace Aimchat\AFCTokenBundle\Exception;

/**
 * Class AFCTokenException
 *
 * @package Aimchat\AFCTokenBundle
 */
abstract class AFCTokenException extends \Exception
{
	const MESSAGE = 'Unexpected exception';

	/**
	 * AFCTokenException constructor.
	 *
	 * @param string          $message
	 * @param int             $code
	 * @param \Throwable|NULL $previous
	 */
	public function __construct(string $message = "", int $code = 0, \Throwable $previous = NULL) {

		parent::__construct( $message?:static::MESSAGE, $code, $previous);
	}
}