<?php

namespace AFCTokenBundle;

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