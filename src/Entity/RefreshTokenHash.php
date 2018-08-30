<?php
/**
 * Created by PhpStorm.
 * User: omni
 * Date: 26.06.2018
 * Time: 23:32
 */

namespace Umbrella\AFCTokenBundle\Entity;

use Umbrella\AFCTokenBundle\RefreshTokenInterface;
use Umbrella\AFCTokenBundle\TokenInterface;


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
	 * @param \Umbrella\AFCTokenBundle\TokenInterface $Token
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