<?php
/**
 * Created by PhpStorm.
 * User: omni
 * Date: 15.11.2018
 * Time: 20:36
 */

namespace Umbrella\AFCTokenBundle\Exception;

/**
 * Class TokenAuthorizationFailedException
 *
 * @package Exception
 */
class AuthorizationFailedException extends AFCTokenReasonException
{
	const MESSAGE = "Token authorization failed";
}