<?php
/**
 * Created by PhpStorm.
 * User: omni
 * Date: 15.11.2018
 * Time: 19:50
 */

namespace Umbrella\AFCTokenBundle\Exception;

/**
 * Class AFCTokenReasonException
 *
 * @package Umbrella\AFCTokenBundle\Exception
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