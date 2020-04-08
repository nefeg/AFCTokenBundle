<?php

namespace AFCTokenBundle\Exception;

/**
 * Class InvalidRefreshTokenException
 *
 * @package AFCTokenBundle\Utils\Exception
 */
class RefreshTokenInvalidException extends AFCTokenException
{
	const MESSAGE = 'invalid refresh-token.';
}