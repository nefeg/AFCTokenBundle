<?php

namespace Aimchat\AFCTokenBundle\Exception;

/**
 * Class TokenDeserializationFailException
 *
 * @package Aimchat\AFCTokenBundle\Exception
 */
class DeserializationFailException extends AFCTokenReasonException
{
	const MESSAGE = "Token deserialization failed.";
}