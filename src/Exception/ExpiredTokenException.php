<?php
/**
 * Created by PhpStorm.
 * User: omni
 * Date: 15.11.2018
 * Time: 17:29
 */

namespace Umbrella\AFCTokenBundle\Exception;

/**
 * Class TokenExpiredException
 *
 * @package Exception
 */
class ExpiredTokenException extends AFCTokenException
{
	const MESSAGE = "Expired token";
}