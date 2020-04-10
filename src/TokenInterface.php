<?php

namespace Aimchat\AFCTokenBundle;

use Aimchat\JCLibPack\JCDateTime;

/**
 * Interface TokenInterface
 *
 * @package Aimchat\AFCTokenBundle
 *
 * @throws \Aimchat\AFCTokenBundle\Exception\TokenConstructorFailException
 * @throws \Aimchat\AFCTokenBundle\Exception\TokenImmutableDataException
 */
interface TokenInterface
{
	/**
	 * Mark token as authorized.
	 *
	 * @return \Aimchat\AFCTokenBundle\TokenInterface
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
	 * @param \Aimchat\AFCTokenBundle\RefreshTokenInterface $RefreshToken
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
	 * @return \Aimchat\JCLibPack\JCDateTime
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