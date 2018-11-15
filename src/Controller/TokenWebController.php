<?php
/**
 * Created by PhpStorm.
 * User: omni
 * Date: 13.11.2018
 * Time: 21:49
 */

namespace Umbrella\AFCTokenBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Umbrella\AFCTokenBundle\Controller\Exception\NoTokenException;
use Umbrella\AFCTokenBundle\Controller\Exception\UnauthorizedException;
use Umbrella\AFCTokenBundle\Exception\AuthorizationFailedException;
use Umbrella\AFCTokenBundle\Exception\DeserializationFailException;
use Umbrella\AFCTokenBundle\Exception\ExpiredTokenException;
use Umbrella\AFCTokenBundle\TokenInterface;


/**
 * Class TokenWebController
 *
 * @package Umbrella\AFCTokenBundle\Controller
 */
abstract class TokenWebController extends TokenController
{
	/**
	 * Return authorized token
	 *
	 * @param \Symfony\Component\HttpFoundation\Request $Request
	 * @return \Umbrella\AFCTokenBundle\TokenInterface
	 * @throws \Umbrella\AFCTokenBundle\Controller\Exception\UnauthorizedException
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