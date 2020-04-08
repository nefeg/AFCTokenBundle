<?php

namespace AFCTokenBundle\Controller\Exception;

/**
 * Class UnauthorizedException
 *
 * @package Controller\Exception
 */
class UnauthorizedException extends TokenControllerException
{
	const MESSAGE = "Unauthorized token";
}