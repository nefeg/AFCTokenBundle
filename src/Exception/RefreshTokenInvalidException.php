<?php
/**
 * Created by PhpStorm.
 * User: omni
 * Date: 13.11.2018
 * Time: 19:31
 */

namespace Umbrella\AFCTokenBundle\Exception;


/**
 * Class InvalidRefreshTokenException
 *
 * @package Umbrella\AFCTokenBundle\Utils\Exception
 */
class RefreshTokenInvalidException extends AFCTokenException
{
	const MESSAGE = 'invalid refresh-token.';
}