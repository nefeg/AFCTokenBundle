<?php

namespace Aimchat\AFCTokenBundle\Entity;

use Aimchat\AFCTokenBundle\TokenRequestInterface;

/**
 * Class TokenRequest
 *
 * @package App\v1
 */
class TokenRequest implements TokenRequestInterface
{
	/**
	 * Random string
	 * @var
	 */
	private $code;
	/**
	 * Token ttl
	 * @var \DateTime
	 */
	private $ttl;
	/**
	 * Identifier of resource that token will linked
	 * @var string
	 */
	private $resource;


	/**
	 * TokenRequest constructor.
	 *
	 * @param string $code
	 * @param string $resource
	 * @param int    $ttl
	 */
	public function __construct(string $code, string $resource, int $ttl){
		$this->code     = $code;
		$this->resource = $resource;
		$this->ttl      = $ttl;
	}

	/**
	 * @return mixed
	 */
	public function getCode() :string{
		return $this->code;
	}

	/**
	 * Time to live (seconds)
	 *
	 * @return mixed
	 */
	public function getTtl(): int {
		return $this->ttl;
	}

	/**
	 * @return mixed
	 */
	public function getResource() :string{
		return $this->resource;
	}

}