<?php

namespace AFCTokenBundle\Service;

use AFCTokenBundle\TokenDeserializerInterface;
use AFCTokenBundle\TokenInterface;
use AFCTokenBundle\Utils\JWTTokenSerializer;

/**
 * Class TokenDeserializerService
 *
 * @package AFCTokenBundle\Service
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
	 * @param \AFCTokenBundle\Service\CryptKeyInterface $publicKey
	 */
	public function __construct(string $secret, CryptKeyInterface $publicKey){

		$this->secret       = $secret;
		$this->publicKey    = (string) $publicKey;
	}

	/**
	 * @param string $tokenString
	 * @return \AFCTokenBundle\TokenInterface
	 * @throws \AFCTokenBundle\Exception\DeserializationFailException
	 */
	public function deserialize(string $tokenString): TokenInterface {
		return JWTTokenSerializer::deserialize($tokenString, $this->secret, $this->publicKey);
	}
}