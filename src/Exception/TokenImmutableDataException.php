<?php
/**
 * Created by PhpStorm.
 * User: omni
 * Date: 13.11.2018
 * Time: 18:47
 */

namespace Umbrella\AFCTokenBundle\Exception;


/**
 * Class ImmutableTokenDataException
 *
 * @package Umbrella\AFCTokenBundle\Entity\Exception
 */
class TokenImmutableDataException extends AFCTokenException
{
	const MESSAGE = "It's not possible to change data of authenticated token.";
}