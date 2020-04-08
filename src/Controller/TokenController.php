<?php

namespace AFCTokenBundle\Controller;

use AFCTokenBundle\Controller\Exception\NoTokenException;
use AFCTokenBundle\Controller\Exception\UnauthorizedException;
use AFCTokenBundle\Entity\RefreshToken;
use AFCTokenBundle\Entity\TokenRequest;
use AFCTokenBundle\Exception\DeserializationFailException;
use AFCTokenBundle\TokenDeserializerInterface;
use AFCTokenBundle\TokenServiceInterface;
use AFCTokenBundle\TokenInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class TokenController
 *
 * @package AFCTokenBundle\Controller
 */
abstract class TokenController extends Controller
{
	/**
	 * @return \AFCTokenBundle\TokenDeserializerInterface
	 */
	abstract protected function getDeserializer() :TokenDeserializerInterface;

	/**
	 * @return \AFCTokenBundle\TokenServiceInterface
	 */
	abstract protected function getTokenService() :TokenServiceInterface;


	/**
	 * @param \Symfony\Component\HttpFoundation\Request $Request
	 * @return \AFCTokenBundle\TokenInterface
	 * @throws \AFCTokenBundle\Exception\TokenConstructorFailException
	 */
	protected function createToken(Request $Request) :TokenInterface{
		$TokenRequest = new TokenRequest(
			$Request->query->get("code"),
			$Request->query->get("resource"),
			$Request->query->get("ttl")
		);

		return $this->getTokenService()->create($TokenRequest);
	}


	/**
	 * @param \Symfony\Component\HttpFoundation\Request $Request
	 * @return \AFCTokenBundle\TokenInterface|null
	 * @throws \AFCTokenBundle\Controller\Exception\NoTokenException
	 * @throws \AFCTokenBundle\Exception\DeserializationFailException
	 */
	protected function extractToken(Request $Request) :TokenInterface{

		if( !$tokenString = $Request->headers->get('Authorization'))
			throw new NoTokenException();

		$tokenString = str_replace('Bearer ', '', $tokenString);

		return $this->getDeserializer()->deserialize($tokenString);
	}

	/**
	 * @param string                                    $refresh
	 * @param \Symfony\Component\HttpFoundation\Request $Request
	 * @return \AFCTokenBundle\TokenInterface|null
	 *
	 * @throws \AFCTokenBundle\Controller\Exception\UnauthorizedException
	 * @throws \AFCTokenBundle\Exception\RefreshTokenInvalidException
	 * @throws \AFCTokenBundle\Exception\TokenConstructorFailException
	 */
	public function refreshToken(string $refresh, Request $Request) :TokenInterface{

		$NewToken = null;

		try{
			$Token = $this->extractToken($Request);

			$RefreshToken = new RefreshToken($refresh);

			return $this->getTokenService()->refresh($Token, $RefreshToken);

		}catch (DeserializationFailException|NoTokenException $Exception){
			throw new UnauthorizedException($Exception->getMessage(), 401, $Exception);
		}
	}
}