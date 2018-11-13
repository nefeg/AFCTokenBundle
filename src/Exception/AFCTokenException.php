<?php
/**
 * Created by PhpStorm.
 * User: omni
 * Date: 13.11.2018
 * Time: 18:10
 */

namespace Umbrella\AFCTokenBundle\Exception;

/**
 * Class AFCTokenException
 *
 * @package Umbrella\AFCTokenBundle
 */
abstract class AFCTokenException extends \Exception
{
	const MESSAGE = 'Unexpected exception';

	/**
	 * @return string
	 */
	public function __toString() :string{
		return static::MESSAGE;
	}
}