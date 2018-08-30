<?php
/**
 * Created by PhpStorm.
 * User: omni
 * Date: 25.06.2018
 * Time: 20:01
 */

namespace Umbrella\AFCTokenBundle;

use Umbrella\JCLibPack\JCDateTime;


/**
 * Interface TokenInterface
 *
 * @package App\v1
 */
interface TokenInterface
{
	/**
	 * @return \Umbrella\AFCTokenBundle\TokenInterface
	 */
	public function authenticate() :TokenInterface;
	/**
	 * @return bool
	 */
	public function isAuthenticated() :bool;

	/**
	 * @param \Umbrella\AFCTokenBundle\RefreshTokenInterface $RefreshToken
	 * @return bool
	 */
	public function isValidRefreshToken(RefreshTokenInterface $RefreshToken) :bool;

	/**
	 * @return string
	 */
	public function getRefreshHash() :string;

	/**
	 * @return string
	 */
	public function getResource(): string;

	/**
	 * @return int
	 */
	public function getTtl(): int;

	/**
	 * @return \Umbrella\JCLibPack\JCDateTime
	 */
	public function getAt(): JCDateTime;

	/**
	 * @return string
	 */
	public function getSalt(): string;

	/**
	 * @return array
	 */
	public function getSharedData(): array;

	/**
	 * @return array
	 */
	public function getEncryptedData(): array;
}