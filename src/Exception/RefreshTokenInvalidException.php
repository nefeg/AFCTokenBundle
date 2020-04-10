<?php

namespace Aimchat\AFCTokenBundle\Exception;

/**
 * Class InvalidRefreshTokenException
 *
 * @package Aimchat\AFCTokenBundle\Utils\Exception
 */
class RefreshTokenInvalidException extends AFCTokenException
{
	const MESSAGE = 'invalid refresh-token.';
}