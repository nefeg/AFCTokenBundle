<?php

namespace AFCTokenBundle\Utils;

use AFCTokenBundle\Entity\RefreshTokenCode;
use AFCTokenBundle\Entity\Token;
use AFCTokenBundle\Entity\TokenRequest;
use AFCTokenBundle\Exception\ExpiredTokenException;
use AFCTokenBundle\RefreshTokenInterface;
use AFCTokenBundle\TokenInterface;
use AFCTokenBundle\TokenRequestInterface;
use AFCTokenBundle\Exception\RefreshTokenInvalidException;

class TokenServiceLib
{
	/**
	 * @param \AFCTokenBundle\TokenRequestInterface $TokenRequest
	 * @return \AFCTokenBundle\TokenInterface
	 * @throws \AFCTokenBundle\Exception\TokenConstructorFailException
	 */
	static public function create(TokenRequestInterface $TokenRequest): TokenInterface {

		return new Token(
			$TokenRequest->getResource(),
			$TokenRequest->getTtl(),
			new RefreshTokenCode($TokenRequest->getCode())
		);
	}

	/**
	 * @param \AFCTokenBundle\TokenInterface $Token
	 * @return \AFCTokenBundle\TokenInterface
	 * @throws \AFCTokenBundle\Exception\ExpiredTokenException
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
	 * @param \AFCTokenBundle\TokenInterface        $Token
	 * @param \AFCTokenBundle\RefreshTokenInterface $RefreshToken
	 * @return \AFCTokenBundle\TokenInterface
	 *
	 * @throws \AFCTokenBundle\Exception\RefreshTokenInvalidException
	 * @throws \AFCTokenBundle\Exception\TokenConstructorFailException
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