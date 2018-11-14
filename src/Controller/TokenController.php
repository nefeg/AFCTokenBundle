<?php
/**
 * Created by PhpStorm.
 * User: omni
 * Date: 24.05.2018
 * Time: 19:32
 */

namespace Umbrella\AFCTokenBundle\Controller;

use Umbrella\AFCTokenBundle\Controller\Exception\UnauthorizedException;
use Umbrella\AFCTokenBundle\Entity\RefreshToken;
use Umbrella\AFCTokenBundle\Entity\TokenRequest;
use Umbrella\AFCTokenBundle\Exception\TokenDeserializationFailException;
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
	 * @throws \Umbrella\AFCTokenBundle\Exception\TokenDeserializationFailException
	 */
	protected function extractToken(Request $Request) :?TokenInterface{

		$Token = null;

		if( $tokenString = $Request->headers->get('Authorization')) {

			$tokenString = str_replace('Bearer ', '', $tokenString);

			$Token = $this->getDeserializer()->deserialize($tokenString);

			$this->getTokenService()->authorize($Token);
		}

		return $Token;
	}

	/**
	 * @param string                                    $refresh
	 * @param \Symfony\Component\HttpFoundation\Request $Request
	 * @return \Umbrella\AFCTokenBundle\TokenInterface|null
	 * @throws \Umbrella\AFCTokenBundle\Controller\Exception\UnauthorizedException
	 * @throws \Umbrella\AFCTokenBundle\Exception\InvalidRefreshTokenException
	 * @throws \Umbrella\AFCTokenBundle\Exception\TokenConstructorFailException
	 */
	public function refreshToken(string $refresh, Request $Request) :TokenInterface{

		$NewToken = null;

		try{
			$Token = $this->extractToken($Request);

			if (!$Token) throw new UnauthorizedException();

			$RefreshToken = new RefreshToken($refresh);

			return $this->getTokenService()->refresh($Token, $RefreshToken);


		}catch (TokenDeserializationFailException $Exception){
			throw new UnauthorizedException($Exception->getMessage(), 401, $Exception);
		}
	}
}