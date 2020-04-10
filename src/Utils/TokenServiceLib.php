<?php

namespace Aimchat\AFCTokenBundle\Utils;

use Aimchat\AFCTokenBundle\Entity\RefreshTokenCode;
use Aimchat\AFCTokenBundle\Entity\Token;
use Aimchat\AFCTokenBundle\Entity\TokenRequest;
use Aimchat\AFCTokenBundle\Exception\ExpiredTokenException;
use Aimchat\AFCTokenBundle\RefreshTokenInterface;
use Aimchat\AFCTokenBundle\TokenInterface;
use Aimchat\AFCTokenBundle\TokenRequestInterface;
use Aimchat\AFCTokenBundle\Exception\RefreshTokenInvalidException;

class TokenServiceLib
{
	/**
	 * @param \Aimchat\AFCTokenBundle\TokenRequestInterface $TokenRequest
	 * @return \Aimchat\AFCTokenBundle\TokenInterface
	 * @throws \Aimchat\AFCTokenBundle\Exception\TokenConstructorFailException
	 */
	static public function create(TokenRequestInterface $TokenRequest): TokenInterface {

		return new Token(
			$TokenRequest->getResource(),
			$TokenRequest->getTtl(),
			new RefreshTokenCode($TokenRequest->getCode())
		);
	}

	/**
	 * @param \Aimchat\AFCTokenBundle\TokenInterface $Token
	 * @return \Aimchat\AFCTokenBundle\TokenInterface
	 * @throws \Aimchat\AFCTokenBundle\Exception\ExpiredTokenException
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
	 * @param \Aimchat\AFCTokenBundle\TokenInterface        $Token
	 * @param \Aimchat\AFCTokenBundle\RefreshTokenInterface $RefreshToken
	 * @return \Aimchat\AFCTokenBundle\TokenInterface
	 *
	 * @throws \Aimchat\AFCTokenBundle\Exception\RefreshTokenInvalidException
	 * @throws \Aimchat\AFCTokenBundle\Exception\TokenConstructorFailException
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