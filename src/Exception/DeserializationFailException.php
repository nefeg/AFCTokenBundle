<?php

namespace AFCTokenBundle\Exception;

/**
 * Class TokenDeserializationFailException
 *
 * @package AFCTokenBundle\Exception
 */
class DeserializationFailException extends AFCTokenReasonException
{
	const MESSAGE = "Token deserialization failed.";
}