<?php

namespace AFCTokenBundle\Exception;

/**
 * Class TokenExpiredException
 *
 * @package Exception
 */
class ExpiredTokenException extends AFCTokenException
{
	const MESSAGE = "Expired token";
}