<?php
/**
 * Created by PhpStorm.
 * User: omni
 * Date: 30.05.2018
 * Time: 21:03
 */

namespace Umbrella\AFCTokenBundle;


/**
 * Interface TokenServiceInterface
 *
 * @package App\v1\Service
 */
interface TokenServiceInterface
{
	/**
	 * @param \Umbrella\AFCTokenBundle\TokenRequestInterface $TokenRequest
	 * @return \Umbrella\AFCTokenBundle\TokenInterface
	 * @throws \Umbrella\AFCTokenBundle\Exception\TokenConstructorFailException
	 */
	public function create(TokenRequestInterface $TokenRequest): TokenInterface;

	/**
	 * @param \Umbrella\AFCTokenBundle\TokenInterface $Token
	 * @return \Umbrella\AFCTokenBundle\TokenInterface
	 * @throws \Umbrella\AFCTokenBundle\Exception\AuthorizationFailedException
	 * @throws \Umbrella\AFCTokenBundle\Exception\ExpiredTokenException
	 */
	public function authorize(TokenInterface $Token): TokenInterface;

	/**
	 * $RefreshToken == hash(code + salt)
	 *
	 * $rhash = hash($RefreshToken + resource + at)
	 *
	 * @param \Umbrella\AFCTokenBundle\TokenInterface        $Token
	 * @param \Umbrella\AFCTokenBundle\RefreshTokenInterface $RefreshToken
	 * @return \Umbrella\AFCTokenBundle\TokenInterface
	 * @throws \Umbrella\AFCTokenBundle\Exception\TokenConstructorFailException
	 * @throws \Umbrella\AFCTokenBundle\Exception\RefreshTokenInvalidException
	 */
	public function refresh(TokenInterface $Token, RefreshTokenInterface $RefreshToken) :TokenInterface;
}