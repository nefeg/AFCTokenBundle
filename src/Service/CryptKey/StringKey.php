<?php

namespace AFCTokenBundle\Service\CryptKey;

use AFCTokenBundle\Service\CryptKeyInterface;

/**
 * Class StringKey
 *
 * @package Service\CryptKey
 */
class StringKey implements CryptKeyInterface
{
	/**
	 * @var string
	 */
	private $keyString;

	/**
	 * StringKey constructor.
	 *
	 * @param string $keyString
	 */
	public function __construct(string $keyString){

		$this->keyString = $keyString;
	}

	/**
	 * @return string
	 */
	public function __toString(): string {
		return $this->keyString;
	}
}