<?php
/**
 * Created by PhpStorm.
 * User: omni
 * Date: 13.11.2018
 * Time: 20:34
 */

namespace Umbrella\AFCTokenBundle\Exception;

/**
 * Class TokenDeserializationFailException
 *
 * @package Umbrella\AFCTokenBundle\Exception
 */
class DeserializationFailException extends AFCTokenReasonException
{
	const MESSAGE = "Token deserialization failed.";
}