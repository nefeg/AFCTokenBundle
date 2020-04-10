<?php

namespace Aimchat\AFCTokenBundle\Service;

use Aimchat\AFCTokenBundle\RefreshTokenInterface;
use Aimchat\AFCTokenBundle\TokenInterface;
use Aimchat\AFCTokenBundle\TokenRequestInterface;
use Aimchat\AFCTokenBundle\TokenServiceInterface;
use Aimchat\AFCTokenBundle\Utils\TokenServiceLib;

/**
 * Class StubTokenService
 *
 * @package Aimchat\AFCTokenBundle\Service
 */
class TokenService implements TokenServiceInterface
{
	/**
	 * @param \Aimchat\AFCTokenBundle\TokenRequestInterface $TokenRequest
	 * @return \Aimchat\AFCTokenBundle\TokenInterface
	 * @throws \Aimchat\AFCTokenBundle\Exception\TokenConstructorFailException
	 */
	public function create(TokenRequestInterface $TokenRequest): TokenInterface {

		return TokenServiceLib::create($TokenRequest);
	}

	/**
	 * @param \Aimchat\AFCTokenBundle\TokenInterface $Token
	 * @return \Aimchat\AFCTokenBundle\TokenInterface
	 * @throws \Aimchat\AFCTokenBundle\Exception\ExpiredTokenException
	 */
	public function authorize(TokenInterface $Token): TokenInterface {

		return TokenServiceLib::authorize($Token);
	}

	/**
	 * $RefreshToken == hash(code + salt)
	 *
	 * $rhash = hash($RefreshToken + resource + at)
	 *
	 * @param \Aimchat\AFCTokenBundle\TokenInterface        $Token
	 * @param \Aimchat\AFCTokenBundle\RefreshTokenInterface $RefreshToken
	 * @return \Aimchat\AFCTokenBundle\TokenInterface
	 * @throws \Aimchat\AFCTokenBundle\Exception\RefreshTokenInvalidException
	 * @throws \Aimchat\AFCTokenBundle\Exception\TokenConstructorFailException
	 */
	public function refresh(TokenInterface $Token, RefreshTokenInterface $RefreshToken) :TokenInterface{

		return TokenServiceLib::refresh($Token, $RefreshToken);
	}
}