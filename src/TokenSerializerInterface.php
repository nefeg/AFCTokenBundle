<?php

namespace Umbrella\AFCTokenBundle;

/**
 * Interface TokenSerializerInterface
 *
 * @package Umbrella\AFCTokenBundle
 */
interface TokenSerializerInterface
{
	/**
	 * @param \Umbrella\AFCTokenBundle\TokenInterface $Token
	 * @return string
	 */
	public function serialize(TokenInterface $Token): string;
}