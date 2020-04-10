<?php

namespace Aimchat\AFCTokenBundle;

use Aimchat\AFCTokenBundle\Exception\DeserializationFailException;

/**
 * Interface TokenDeserializerInterface
 *
 * @package Aimchat\AFCTokenBundle
 */
interface TokenDeserializerInterface{
	/**
	 * @param string $tokenString
	 * @return \Aimchat\AFCTokenBundle\TokenInterface
	 *
	 * @throws DeserializationFailException
	 */
	public function deserialize(string $tokenString): TokenInterface;
}