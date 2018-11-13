<?php
/**
 * Created by PhpStorm.
 * User: omni
 * Date: 13.11.2018
 * Time: 18:05
 */

namespace Umbrella\AFCTokenBundle\Controller\Exception;

/**
 * Class NoTokenException
 *
 * @package Controller
 */
class NoTokenException extends TokenControllerException
{
	const MESSAGE = 'Token not exist';
}