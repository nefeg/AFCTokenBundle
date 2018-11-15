<?php
/**
 * Created by PhpStorm.
 * User: omni
 * Date: 24.05.2018
 * Time: 19:32
 */

namespace Umbrella\AFCTokenBundle\Controller;

use Umbrella\AFCTokenBundle\Controller\Exception\NoTokenException;
use Umbrella\AFCTokenBundle\Controller\Exception\UnauthorizedException;
use Umbrella\AFCTokenBundle\Entity\RefreshToken;
use Umbrella\AFCTokenBundle\Entity\TokenRequest;
use Umbrella\AFCTokenBundle\Exception\AuthorizationFailedException;
use Umbrella\AFCTokenBundle\Exception\DeserializationFailException;
use Umbrella\AFCTokenBundle\TokenDeserializerInterface;
use Umbrella\AFCTokenBundle\TokenServiceInterface;
use Umbrella\AFCTokenBundle\TokenInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class TokenController
 *
 * @package Umbrella\AFCTokenBundle\Controller
 */
abstract class TokenController extends Controller
{
	/**
	 * @return \Umbrella\AFCTokenBundle\TokenDeserializerInterface
	 */
	abstract protected function getDeserializer() :TokenDeserializerInterface;

	/**
	 * @return \Umbrella\AFCTokenBundle\TokenServiceInterface
	 */
	abstract protected function getTokenService() :TokenServiceInterface;


	/**
	 * @param \Symfony\Component\HttpFoundation\Request $Request
	 * @return \Umbrella\AFCTokenBundle\TokenInterface
	 * @throws \Umbrella\AFCTokenBundle\Exception\TokenConstructorFailException
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
	 * @return \Umbrella\AFCTokenBundle\TokenInterface|null
	 * @throws \Umbrella\AFCTokenBundle\Controller\Exception\NoTokenException
	 * @throws \Umbrella\AFCTokenBundle\Exception\DeserializationFailException
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
	 * @return \Umbrella\AFCTokenBundle\TokenInterface|null
	 *
	 * @throws \Umbrella\AFCTokenBundle\Controller\Exception\UnauthorizedException
	 * @throws \Umbrella\AFCTokenBundle\Exception\RefreshTokenInvalidException
	 * @throws \Umbrella\AFCTokenBundle\Exception\TokenConstructorFailException
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