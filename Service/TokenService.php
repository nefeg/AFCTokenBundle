<?php
/**
 * Created by PhpStorm.
 * User: omni
 * Date: 30.05.2018
 * Time: 21:27
 */

namespace Umbrella\AFCTokenBundle\Service;

use Umbrella\AFCTokenBundle\Entity\RefreshTokenCode;
use Umbrella\AFCTokenBundle\Entity\Token;
use Umbrella\AFCTokenBundle\Entity\TokenRequest;
use Umbrella\AFCTokenBundle\RefreshTokenInterface;
use Umbrella\AFCTokenBundle\TokenInterface;
use Umbrella\AFCTokenBundle\TokenRequestInterface;
use Umbrella\AFCTokenBundle\TokenServiceInterface;

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

		$Token = new Token(
			$TokenRequest->getResource(),
			$TokenRequest->getTtl(),
			new RefreshTokenCode($TokenRequest->getCode())
		);

		return $Token->authenticate();
	}

	/**
	 * @param \Umbrella\AFCTokenBundle\TokenInterface $Token
	 * @return \Umbrella\AFCTokenBundle\TokenInterface
	 * @throw \Exception
	 */
	public function authorize(TokenInterface $Token): TokenInterface {

		$Token->authenticate();

		return $Token;
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

		if ( !$Token->isValidRefreshToken($RefreshToken) ) {
			throw new \Exception('Invalid refresh token');
		}

		return $this->create(
			new TokenRequest($RefreshToken->getSource(), $Token->getResource(), $Token->getTtl())
		);
	}
}