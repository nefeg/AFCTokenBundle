<?php
/**
 * Created by PhpStorm.
 * User: omni
 * Date: 30.08.2018
 * Time: 15:29
 */

namespace Umbrella\AFCTokenBundle\Utils;


use Umbrella\AFCTokenBundle\Entity\RefreshTokenCode;
use Umbrella\AFCTokenBundle\Entity\Token;
use Umbrella\AFCTokenBundle\Entity\TokenRequest;
use Umbrella\AFCTokenBundle\Exception\ExpiredTokenException;
use Umbrella\AFCTokenBundle\RefreshTokenInterface;
use Umbrella\AFCTokenBundle\TokenInterface;
use Umbrella\AFCTokenBundle\TokenRequestInterface;
use Umbrella\AFCTokenBundle\Exception\RefreshTokenInvalidException;

class TokenServiceLib
{
	/**
	 * @param \Umbrella\AFCTokenBundle\TokenRequestInterface $TokenRequest
	 * @return \Umbrella\AFCTokenBundle\TokenInterface
	 * @throws \Umbrella\AFCTokenBundle\Exception\TokenConstructorFailException
	 */
	static public function create(TokenRequestInterface $TokenRequest): TokenInterface {

		return new Token(
			$TokenRequest->getResource(),
			$TokenRequest->getTtl(),
			new RefreshTokenCode($TokenRequest->getCode())
		);
	}

	/**
	 * @param \Umbrella\AFCTokenBundle\TokenInterface $Token
	 * @return \Umbrella\AFCTokenBundle\TokenInterface
	 * @throws \Umbrella\AFCTokenBundle\Exception\ExpiredTokenException
	 */
	static public function authorize(TokenInterface $Token): TokenInterface {

		if ($Token->isExpired())
			throw new ExpiredTokenException;

		$Token->authorize();

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
	 *
	 * @throws \Umbrella\AFCTokenBundle\Exception\RefreshTokenInvalidException
	 * @throws \Umbrella\AFCTokenBundle\Exception\TokenConstructorFailException
	 */
	static public function refresh(TokenInterface $Token, RefreshTokenInterface $RefreshToken) :TokenInterface{

		if ( !$Token->isValidRefreshToken($RefreshToken) ) {
			throw new RefreshTokenInvalidException();
		}

		try{
			static::authorize($Token);
		}catch (ExpiredTokenException $ExpiredTokenException){
			// to do nothing, because it's normal for refresh action
		}

		$NewToken = static::create(
			new TokenRequest($RefreshToken->getSource(), $Token->getResource(), $Token->getTtl())
		);

		return $NewToken;
	}
}