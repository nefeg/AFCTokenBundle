<?php

namespace AFCTokenBundle\Controller\Exception;

/**
 * Class NoTokenException
 *
 * @package Controller
 */
class NoTokenException extends TokenControllerException
{
	const MESSAGE = 'Token not exist';
}