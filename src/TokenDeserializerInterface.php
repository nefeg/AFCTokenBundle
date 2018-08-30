<?php

namespace Umbrella\AFCTokenBundle;

/**
 * Interface TokenDeserializerInterface
 *
 * @package Umbrella\AFCTokenBundle
 */
interface TokenDeserializerInterface{
	/**
	 * @param string $tokenString
	 * @return \Umbrella\AFCTokenBundle\TokenInterface
	 * @throws \Exception
	 */
	public function deserialize(string $tokenString): TokenInterface;
}