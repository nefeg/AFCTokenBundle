<?php
/**
 * Created by PhpStorm.
 * User: omni
 * Date: 13.11.2018
 * Time: 20:02
 */

namespace Umbrella\AFCTokenBundle\Exception;

/**
 * Class TokenConstructorFailException
 *
 * @package Umbrella\AFCTokenBundle\Exception
 */
class TokenConstructorFailException extends AFCTokenException
{
	const MESSAGE = "Token constructor fail.";
}