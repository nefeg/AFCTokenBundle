<?php
/**
 * Created by PhpStorm.
 * User: omni
 * Date: 22.06.2018
 * Time: 1:42
 */

namespace Umbrella\AFCTokenBundle;

/**
 * Interface RefreshTokenInterface
 *
 * @package App\v1
 */
interface RefreshTokenInterface
{
	/**
	 * @param \Umbrella\AFCTokenBundle\TokenInterface $Token
	 * @return string
	 */
	public function generateHash(TokenInterface $Token) :string;

	/**
	 * @return string
	 */
	public function getSource() :string;
}