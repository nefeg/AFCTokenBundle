<?php
/**
 * Created by PhpStorm.
 * User: omni
 * Date: 30.08.2018
 * Time: 20:19
 */

namespace Umbrella\AFCTokenBundle\Service\CryptKey;

use Umbrella\AFCTokenBundle\Service\CryptKeyInterface;

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