<?php

namespace Aimchat\AFCTokenBundle\Exception;

/**
 * Class ImmutableTokenDataException
 *
 * @package Aimchat\AFCTokenBundle\Entity\Exception
 */
class TokenImmutableDataException extends AFCTokenException
{
	const MESSAGE = "It's not possible to change data of authenticated token.";
}