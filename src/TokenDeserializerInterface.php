<?php

namespace Umbrella\AFCTokenBundle;

use Umbrella\AFCTokenBundle\Exception\TokenDeserializationFailException;

/**
 * Interface TokenDeserializerInterface
 *
 * @package Umbrella\AFCTokenBundle
 */
interface TokenDeserializerInterface{
	/**
	 * @param string $tokenString
	 * @return \Umbrella\AFCTokenBundle\TokenInterface
	 *
	 * @throws TokenDeserializationFailException
	 */
	public function deserialize(string $tokenString): TokenInterface;
}