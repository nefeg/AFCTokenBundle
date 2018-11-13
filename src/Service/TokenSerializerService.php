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

/**
 * Class TokenSerializerService
 *
 * @package Umbrella\AFCTokenBundle\Service
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
	 * @param \Umbrella\AFCTokenBundle\Service\CryptKeyInterface $privateKey
	 */
	public function __construct(string $secret, CryptKeyInterface $privateKey){

		$this->secret       = $secret;
		$this->privateKey   = (string) $privateKey;
	}


	/**
	 * @param \Umbrella\AFCTokenBundle\TokenInterface $Token
	 * @return string
	 */
	public function serialize(TokenInterface $Token): string {

		return JWTTokenSerializer::serialize($Token, $this->secret, $this->privateKey);
	}
}