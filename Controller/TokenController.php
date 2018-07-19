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
use Umbrella\AFCTokenBundle\Utils\JWTTokenSerializer;
use Umbrella\AFCTokenBundle\TokenInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class TokenController
 *
 * @package Umbrella\AFCTokenBundle\Controller
 */
class TokenController extends Controller
{
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

		/** @var \Umbrella\AFCTokenBundle\TokenServiceInterface $TokenService */
		$TokenService = $this->get("app.token.service");
		return $TokenService->create($TokenRequest);
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

			$Token = JWTTokenSerializer::deserialize($tokenString);

			/** @var \Umbrella\AFCTokenBundle\TokenServiceInterface $TokenService */
			$TokenService = $this->get("app.token.service");
			$TokenService->authorize($Token);
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

			/** @var \Umbrella\AFCTokenBundle\TokenServiceInterface $TokenService */
			$TokenService = $this->get("app.token.service");
			$NewToken = $TokenService->refresh($Token, $RefreshToken);
		}

		return $NewToken;
	}
}