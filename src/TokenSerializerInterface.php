<?php

namespace Aimchat\AFCTokenBundle;

/**
 * Interface TokenSerializerInterface
 *
 * @package Aimchat\AFCTokenBundle
 */
interface TokenSerializerInterface
{
	/**
	 * @param \Aimchat\AFCTokenBundle\TokenInterface $Token
	 * @return string
	 */
	public function serialize(TokenInterface $Token): string;
}