<?php

namespace Aimchat\AFCTokenBundle\Service;

use Aimchat\AFCTokenBundle\TokenDeserializerInterface;
use Aimchat\AFCTokenBundle\TokenInterface;
use Aimchat\AFCTokenBundle\Utils\JWTTokenSerializer;

/**
 * Class TokenDeserializerService
 *
 * @package Aimchat\AFCTokenBundle\Service
 */
class TokenDeserializerService implements TokenDeserializerInterface
{
	/**
	 * @var string
	 */
	private $secret;
	/**
	 * @var string
	 */
	private $publicKey;

	/**
	 * TokenDeserializerService constructor.
	 *
	 * @param string                                             $secret
	 * @param \Aimchat\AFCTokenBundle\Service\CryptKeyInterface $publicKey
	 */
	public function __construct(string $secret, CryptKeyInterface $publicKey){

		$this->secret       = $secret;
		$this->publicKey    = (string) $publicKey;
	}

	/**
	 * @param string $tokenString
	 * @return \Aimchat\AFCTokenBundle\TokenInterface
	 * @throws \Aimchat\AFCTokenBundle\Exception\DeserializationFailException
	 */
	public function deserialize(string $tokenString): TokenInterface {
		return JWTTokenSerializer::deserialize($tokenString, $this->secret, $this->publicKey);
	}
}