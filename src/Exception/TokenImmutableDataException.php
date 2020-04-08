<?php

namespace AFCTokenBundle\Exception;

/**
 * Class ImmutableTokenDataException
 *
 * @package AFCTokenBundle\Entity\Exception
 */
class TokenImmutableDataException extends AFCTokenException
{
	const MESSAGE = "It's not possible to change data of authenticated token.";
}