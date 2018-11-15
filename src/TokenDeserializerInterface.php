<?php

namespace Umbrella\AFCTokenBundle;

use Umbrella\AFCTokenBundle\Exception\DeserializationFailException;

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
	 * @throws DeserializationFailException
	 */
	public function deserialize(string $tokenString): TokenInterface;
}