<?php

namespace Aimchat\AFCTokenBundle\Service;

use Aimchat\AFCTokenBundle\TokenInterface;
use Aimchat\AFCTokenBundle\TokenSerializerInterface;
use Aimchat\AFCTokenBundle\Utils\JWTTokenSerializer;

/**
 * Class TokenSerializerService
 *
 * @package Aimchat\AFCTokenBundle\Service
 */
class TokenSerializerService implements TokenSerializerInterface
{
	/**
	 * @var string
	 */
	private $secret;
	/**
	 * @var string
	 */
	private $privateKey;

	/**
	 * TokenSerializerService constructor.
	 *
	 * @param string                                             $secret
	 * @param \Aimchat\AFCTokenBundle\Service\CryptKeyInterface $privateKey
	 */
	public function __construct(string $secret, CryptKeyInterface $privateKey){

		$this->secret       = $secret;
		$this->privateKey   = (string) $privateKey;
	}


	/**
	 * @param \Aimchat\AFCTokenBundle\TokenInterface $Token
	 * @return string
	 */
	public function serialize(TokenInterface $Token): string {

		return JWTTokenSerializer::serialize($Token, $this->secret, $this->privateKey);
	}
}