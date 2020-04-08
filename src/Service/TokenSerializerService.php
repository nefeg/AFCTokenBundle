<?php

namespace AFCTokenBundle\Service;

use AFCTokenBundle\TokenInterface;
use AFCTokenBundle\TokenSerializerInterface;
use AFCTokenBundle\Utils\JWTTokenSerializer;

/**
 * Class TokenSerializerService
 *
 * @package AFCTokenBundle\Service
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
	 * @param \AFCTokenBundle\Service\CryptKeyInterface $privateKey
	 */
	public function __construct(string $secret, CryptKeyInterface $privateKey){

		$this->secret       = $secret;
		$this->privateKey   = (string) $privateKey;
	}


	/**
	 * @param \AFCTokenBundle\TokenInterface $Token
	 * @return string
	 */
	public function serialize(TokenInterface $Token): string {

		return JWTTokenSerializer::serialize($Token, $this->secret, $this->privateKey);
	}
}