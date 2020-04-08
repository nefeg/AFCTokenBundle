<?php

namespace AFCTokenBundle;

/**
 * Interface TokenServiceInterface
 *
 * @package App\v1\Service
 */
interface TokenServiceInterface
{
	/**
	 * @param \AFCTokenBundle\TokenRequestInterface $TokenRequest
	 * @return \AFCTokenBundle\TokenInterface
	 * @throws \AFCTokenBundle\Exception\TokenConstructorFailException
	 */
	public function create(TokenRequestInterface $TokenRequest): TokenInterface;

	/**
	 * @param \AFCTokenBundle\TokenInterface $Token
	 * @return \AFCTokenBundle\TokenInterface
	 * @throws \AFCTokenBundle\Exception\AuthorizationFailedException
	 * @throws \AFCTokenBundle\Exception\ExpiredTokenException
	 */
	public function authorize(TokenInterface $Token): TokenInterface;

	/**
	 * $RefreshToken == hash(code + salt)
	 *
	 * $rhash = hash($RefreshToken + resource + at)
	 *
	 * @param \AFCTokenBundle\TokenInterface        $Token
	 * @param \AFCTokenBundle\RefreshTokenInterface $RefreshToken
	 * @return \AFCTokenBundle\TokenInterface
	 * @throws \AFCTokenBundle\Exception\TokenConstructorFailException
	 * @throws \AFCTokenBundle\Exception\RefreshTokenInvalidException
	 */
	public function refresh(TokenInterface $Token, RefreshTokenInterface $RefreshToken) :TokenInterface;
}