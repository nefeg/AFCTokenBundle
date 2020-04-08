<?php

namespace AFCTokenBundle;

/**
 * Interface TokenSerializerInterface
 *
 * @package AFCTokenBundle
 */
interface TokenSerializerInterface
{
	/**
	 * @param \AFCTokenBundle\TokenInterface $Token
	 * @return string
	 */
	public function serialize(TokenInterface $Token): string;
}