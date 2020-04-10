<?php

namespace Aimchat\AFCTokenBundle\Controller;

use Aimchat\AFCTokenBundle\Controller\Exception\NoTokenException;
use Aimchat\AFCTokenBundle\Controller\Exception\UnauthorizedException;
use Aimchat\AFCTokenBundle\Exception\AuthorizationFailedException;
use Aimchat\AFCTokenBundle\Exception\DeserializationFailException;
use Aimchat\AFCTokenBundle\Exception\ExpiredTokenException;
use Aimchat\AFCTokenBundle\TokenInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class TokenWebController
 *
 * @package Aimchat\AFCTokenBundle\Controller
 */
abstract class TokenWebController extends TokenController
{
	/**
	 * Return authorized token
	 *
	 * @param \Symfony\Component\HttpFoundation\Request $Request
	 * @return \Aimchat\AFCTokenBundle\TokenInterface
	 * @throws \Aimchat\AFCTokenBundle\Controller\Exception\UnauthorizedException
	 */
	public function authorizeRequest(Request $Request) :TokenInterface{

		try{
			// Try to extract token from request
			$Token = $this->extractToken($Request);

			$this->getTokenService()->authorize($Token);

		}catch (NoTokenException|DeserializationFailException|ExpiredTokenException|AuthorizationFailedException $Exception){
			throw new UnauthorizedException($Exception->getMessage(), 401, $Exception);
		}

		return $Token;
	}
}