<?php
/**
 * Created by PhpStorm.
 * User: omni
 * Date: 24.08.2018
 * Time: 22:35
 */

namespace Umbrella\AFCTokenBundle\Service;


use Umbrella\AFCTokenBundle\TokenInterface;
use Umbrella\AFCTokenBundle\TokenSerializerInterface;
use Umbrella\AFCTokenBundle\Utils\JWTTokenSerializer;

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
	 * @param string $secret
	 * @param string $privateKey
	 */
	public function __construct(string $secret, string $privateKey){

		$this->secret       = $secret;
		$this->privateKey   = $privateKey;
	}


	/**
	 * @param \Umbrella\AFCTokenBundle\TokenInterface $Token
	 * @return string
	 */
	public function serialize(TokenInterface $Token): string {

		return JWTTokenSerializer::serialize($Token, $this->secret, $this->privateKey);
	}
}