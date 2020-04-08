<?php

namespace AFCTokenBundle\Service;

use AFCTokenBundle\RefreshTokenInterface;
use AFCTokenBundle\TokenInterface;
use AFCTokenBundle\TokenRequestInterface;
use AFCTokenBundle\TokenServiceInterface;
use AFCTokenBundle\Utils\TokenServiceLib;

/**
 * Class StubTokenService
 *
 * @package AFCTokenBundle\Service
 */
class TokenService implements TokenServiceInterface
{
	/**
	 * @param \AFCTokenBundle\TokenRequestInterface $TokenRequest
	 * @return \AFCTokenBundle\TokenInterface
	 * @throws \AFCTokenBundle\Exception\TokenConstructorFailException
	 */
	public function create(TokenRequestInterface $TokenRequest): TokenInterface {

		return TokenServiceLib::create($TokenRequest);
	}

	/**
	 * @param \AFCTokenBundle\TokenInterface $Token
	 * @return \AFCTokenBundle\TokenInterface
	 * @throws \AFCTokenBundle\Exception\ExpiredTokenException
	 */
	public function authorize(TokenInterface $Token): TokenInterface {

		return TokenServiceLib::authorize($Token);
	}

	/**
	 * $RefreshToken == hash(code + salt)
	 *
	 * $rhash = hash($RefreshToken + resource + at)
	 *
	 * @param \AFCTokenBundle\TokenInterface        $Token
	 * @param \AFCTokenBundle\RefreshTokenInterface $RefreshToken
	 * @return \AFCTokenBundle\TokenInterface
	 * @throws \AFCTokenBundle\Exception\RefreshTokenInvalidException
	 * @throws \AFCTokenBundle\Exception\TokenConstructorFailException
	 */
	public function refresh(TokenInterface $Token, RefreshTokenInterface $RefreshToken) :TokenInterface{

		return TokenServiceLib::refresh($Token, $RefreshToken);
	}
}