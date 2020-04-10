<?php

namespace Aimchat\AFCTokenBundle\Entity;

use Aimchat\AFCTokenBundle\RefreshTokenInterface;
use Aimchat\AFCTokenBundle\TokenInterface;

/**
 * Class RefreshTokenHash
 *
 * @package App\v1
 */
class RefreshTokenHash implements RefreshTokenInterface
{
	/**
	 * @var string
	 */
	private $refreshTokenHash;

	/**
	 * RefreshTokenHash constructor.
	 *
	 * @param string $refreshTokenHash
	 */
	public function __construct(string $refreshTokenHash){

		$this->refreshTokenHash = $refreshTokenHash;
	}

	/**
	 * @param \Aimchat\AFCTokenBundle\TokenInterface $Token
	 * @return string
	 */
	public function generateHash(TokenInterface $Token): string {

//		var_dump('<<< Hash >>>');
//		var_dump("raw hash: " .$this->refreshTokenHash);
//		var_dump('<<< /Hash >>>');

		return $this->refreshTokenHash;
	}

	/**
	 * @return string
	 */
	public function getSource(): string {
		return $this->refreshTokenHash;
	}
}