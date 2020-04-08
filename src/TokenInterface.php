<?php

namespace AFCTokenBundle;

use JCLibPack\JCDateTime;

/**
 * Interface TokenInterface
 *
 * @package AFCTokenBundle
 *
 * @throws \AFCTokenBundle\Exception\TokenConstructorFailException
 * @throws \AFCTokenBundle\Exception\TokenImmutableDataException
 */
interface TokenInterface
{
	/**
	 * Mark token as authorized.
	 *
	 * @return \AFCTokenBundle\TokenInterface
	 */
	public function authorize() :TokenInterface;
	/**
	 * @return bool
	 */
	public function isAuthorized() :bool;

	/**
	 * @return bool
	 */
	public function isExpired() :bool;

	/**
	 * @param \AFCTokenBundle\RefreshTokenInterface $RefreshToken
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
	 * @return \JCLibPack\JCDateTime
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