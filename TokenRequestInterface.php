<?php
/**
 * Created by PhpStorm.
 * User: omni
 * Date: 19.06.2018
 * Time: 23:02
 */

namespace Umbrella\AFCTokenBundle;

/**
 * Interface TokenRequestInterface
 *
 * @package App\v1
 */
interface TokenRequestInterface
{
	/**
	 * @return mixed
	 */
	public function getCode() :string;
	/**
	 * Token ttl (seconds)
	 * @return mixed
	 */
	public function getTtl() :int;
	/**
	 * @return mixed
	 */
	public function getResource() :string;
}