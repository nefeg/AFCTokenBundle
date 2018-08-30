<?php
/**
 * Created by PhpStorm.
 * User: omni
 * Date: 30.05.2018
 * Time: 21:27
 */

namespace Umbrella\AFCTokenBundle\Service;

use Umbrella\AFCTokenBundle\RefreshTokenInterface;
use Umbrella\AFCTokenBundle\TokenInterface;
use Umbrella\AFCTokenBundle\TokenRequestInterface;
use Umbrella\AFCTokenBundle\TokenServiceInterface;
use Umbrella\AFCTokenBundle\Utils\TokenServiceLib;

/**
 * Class StubTokenService
 *
 * @package Umbrella\AFCTokenBundle\Service
 */
class TokenService implements TokenServiceInterface
{
	/**
	 * @param \Umbrella\AFCTokenBundle\TokenRequestInterface $TokenRequest
	 * @return \Umbrella\AFCTokenBundle\TokenInterface
	 * @throws \Exception
	 * @throw \Exception
	 */
	public function create(TokenRequestInterface $TokenRequest): TokenInterface {

		return TokenServiceLib::create($TokenRequest);
	}

	/**
	 * @param \Umbrella\AFCTokenBundle\TokenInterface $Token
	 * @return \Umbrella\AFCTokenBundle\TokenInterface
	 * @throw \Exception
	 */
	public function authorize(TokenInterface $Token): TokenInterface {

		return TokenServiceLib::authorize($Token);
	}

	/**
	 * $RefreshToken == hash(code + salt)
	 *
	 * $rhash = hash($RefreshToken + resource + at)
	 *
	 * @param \Umbrella\AFCTokenBundle\TokenInterface        $Token
	 * @param \Umbrella\AFCTokenBundle\RefreshTokenInterface $RefreshToken
	 * @return \Umbrella\AFCTokenBundle\TokenInterface
	 * @throws \Exception
	 */
	public function refresh(TokenInterface $Token, RefreshTokenInterface $RefreshToken) :TokenInterface{

		return TokenServiceLib::refresh($Token, $RefreshToken);
	}
}