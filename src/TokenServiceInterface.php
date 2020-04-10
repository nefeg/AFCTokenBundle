<?php

namespace Aimchat\AFCTokenBundle;

/**
 * Interface TokenServiceInterface
 *
 * @package App\v1\Service
 */
interface TokenServiceInterface
{
	/**
	 * @param \Aimchat\AFCTokenBundle\TokenRequestInterface $TokenRequest
	 * @return \Aimchat\AFCTokenBundle\TokenInterface
	 * @throws \Aimchat\AFCTokenBundle\Exception\TokenConstructorFailException
	 */
	public function create(TokenRequestInterface $TokenRequest): TokenInterface;

	/**
	 * @param \Aimchat\AFCTokenBundle\TokenInterface $Token
	 * @return \Aimchat\AFCTokenBundle\TokenInterface
	 * @throws \Aimchat\AFCTokenBundle\Exception\AuthorizationFailedException
	 * @throws \Aimchat\AFCTokenBundle\Exception\ExpiredTokenException
	 */
	public function authorize(TokenInterface $Token): TokenInterface;

	/**
	 * $RefreshToken == hash(code + salt)
	 *
	 * $rhash = hash($RefreshToken + resource + at)
	 *
	 * @param \Aimchat\AFCTokenBundle\TokenInterface        $Token
	 * @param \Aimchat\AFCTokenBundle\RefreshTokenInterface $RefreshToken
	 * @return \Aimchat\AFCTokenBundle\TokenInterface
	 * @throws \Aimchat\AFCTokenBundle\Exception\TokenConstructorFailException
	 * @throws \Aimchat\AFCTokenBundle\Exception\RefreshTokenInvalidException
	 */
	public function refresh(TokenInterface $Token, RefreshTokenInterface $RefreshToken) :TokenInterface;
}