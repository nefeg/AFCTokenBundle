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
use Umbrella\AFCTokenBundle\Exception\TokenDeserializationFailException;
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

			// Check for extracted token
			if (!$Token || !$Token->isAuthenticated())
				throw new NoTokenException();

		}catch (NoTokenException|TokenDeserializationFailException $Exception){
			throw new UnauthorizedException("", 401, $Exception);
		}

		return $Token;
	}
}