<?php

namespace AFCTokenBundle;

/**
 * Interface RefreshTokenInterface
 *
 * @package App\v1
 */
interface RefreshTokenInterface
{
	/**
	 * @param \AFCTokenBundle\TokenInterface $Token
	 * @return string
	 */
	public function generateHash(TokenInterface $Token) :string;

	/**
	 * @return string
	 */
	public function getSource() :string;
}