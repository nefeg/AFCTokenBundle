<?php

namespace AFCTokenBundle;

use AFCTokenBundle\Exception\DeserializationFailException;

/**
 * Interface TokenDeserializerInterface
 *
 * @package AFCTokenBundle
 */
interface TokenDeserializerInterface{
	/**
	 * @param string $tokenString
	 * @return \AFCTokenBundle\TokenInterface
	 *
	 * @throws DeserializationFailException
	 */
	public function deserialize(string $tokenString): TokenInterface;
}