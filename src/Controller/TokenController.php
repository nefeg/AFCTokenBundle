<?php
/**
 * Created by PhpStorm.
 * User: omni
 * Date: 24.05.2018
 * Time: 19:32
 */

namespace Umbrella\AFCTokenBundle\Controller;

use Umbrella\AFCTokenBundle\Entity\RefreshToken;
use Umbrella\AFCTokenBundle\Entity\TokenRequest;
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
	 * @throws \Exception
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
	 * @throws \Exception
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
	 * @throws \Exception
	 */
	public function refreshToken(string $refresh, Request $Request) :?TokenInterface{

		$NewToken = null;

		if ($Token = $this->extractToken($Request)){
			$RefreshToken = new RefreshToken($refresh);

			$NewToken = $this->getTokenService()->refresh($Token, $RefreshToken);
		}

		return $NewToken;
	}


	/**
	 * Return authorized token
	 *
	 * @param \Symfony\Component\HttpFoundation\Request $Request
	 * @return \Umbrella\AFCTokenBundle\TokenInterface
	 * @throws \Exception
	 */
	public function authorizeRequest(Request $Request) :TokenInterface{

		// Try to extract token from request
		$Token = $this->extractToken($Request);

		// Check for extracted token
		if (!$Token || !$Token->isAuthenticated())
			throw new \Exception('Token not exist');

		return $Token;
	}
}