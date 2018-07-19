<?php
/**
 * Created by PhpStorm.
 * User: omni
 * Date: 19.07.2018
 * Time: 0:00
 */

namespace Umbrella\AFCTokenBundle;


interface TokenSerializationServiceInterface
{
	/**
	 * @param \Umbrella\AFCTokenBundle\TokenInterface $Token
	 * @return string
	 */
	public function serialize(TokenInterface $Token): string;

	/**
	 * @param string $tokenString
	 * @return \Umbrella\AFCTokenBundle\TokenInterface
	 * @throws \Exception
	 */
	public function deserialize(string $tokenString): TokenInterface;
}