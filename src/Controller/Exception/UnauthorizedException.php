<?php
/**
 * Created by PhpStorm.
 * User: omni
 * Date: 13.11.2018
 * Time: 22:07
 */

namespace Umbrella\AFCTokenBundle\Controller\Exception;

/**
 * Class UnauthorizedException
 *
 * @package Controller\Exception
 */
class UnauthorizedException extends TokenControllerException
{
	const MESSAGE = "Unauthorized token";
}