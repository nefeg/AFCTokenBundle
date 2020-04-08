<?php

namespace AFCTokenBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use AFCTokenBundle\Controller\Exception\NoTokenException;
use AFCTokenBundle\Controller\Exception\UnauthorizedException;
use AFCTokenBundle\Exception\AuthorizationFailedException;
use AFCTokenBundle\Exception\DeserializationFailException;
use AFCTokenBundle\Exception\ExpiredTokenException;
use AFCTokenBundle\TokenInterface;

/**
 * Class TokenWebController
 *
 * @package AFCTokenBundle\Controller
 */
abstract class TokenWebController extends TokenController
{
	/**
	 * Return authorized token
	 *
	 * @param \Symfony\Component\HttpFoundation\Request $Request
	 * @return \AFCTokenBundle\TokenInterface
	 * @throws \AFCTokenBundle\Controller\Exception\UnauthorizedException
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