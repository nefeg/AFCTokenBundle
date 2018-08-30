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
	 * @param string $secret
	 * @param string $publicKey
	 */
	public function __construct(string $secret, string $publicKey){

		$this->secret       = $secret;
		$this->publicKey    = $publicKey;
	}

	/**
	 * @param string $tokenString
	 * @return \Umbrella\AFCTokenBundle\TokenInterface
	 * @throws \Exception
	 */
	public function deserialize(string $tokenString): TokenInterface {

		return JWTTokenSerializer::deserialize($tokenString, $this->secret, $this->publicKey);
	}
}