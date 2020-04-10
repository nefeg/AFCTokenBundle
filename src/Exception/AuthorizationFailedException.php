<?php

namespace Aimchat\AFCTokenBundle\Exception;

/**
 * Class TokenAuthorizationFailedException
 *
 * @package Exception
 */
class AuthorizationFailedException extends AFCTokenReasonException
{
	const MESSAGE = "Token authorization failed";
}