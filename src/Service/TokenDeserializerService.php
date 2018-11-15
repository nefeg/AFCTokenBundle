<?php
/**
 * Created by PhpStorm.
 * User: omni
 * Date: 24.08.2018
 * Time: 22:43
 */

namespace Umbrella\AFCTokenBundle\Service;

use Umbrella\AFCTokenBundle\TokenDeserializerInterface;
use Umbrella\AFCTokenBundle\TokenInterface;
use Umbrella\AFCTokenBundle\Utils\JWTTokenSerializer;

/**
 * Class TokenDeserializerService
 *
 * @package Umbrella\AFCTokenBundle\Service
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
	 * @param \Umbrella\AFCTokenBundle\Service\CryptKeyInterface $publicKey
	 */
	public function __construct(string $secret, CryptKeyInterface $publicKey){

		$this->secret       = $secret;
		$this->publicKey    = (string) $publicKey;
	}

	/**
	 * @param string $tokenString
	 * @return \Umbrella\AFCTokenBundle\TokenInterface
	 * @throws \Umbrella\AFCTokenBundle\Exception\DeserializationFailException
	 */
	public function deserialize(string $tokenString): TokenInterface {
		return JWTTokenSerializer::deserialize($tokenString, $this->secret, $this->publicKey);
	}
}