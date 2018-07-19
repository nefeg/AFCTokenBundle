<?php
/**
 * Created by PhpStorm.
 * User: omni
 * Date: 26.06.2018
 * Time: 2:33
 */

namespace Umbrella\AFCTokenBundle\Entity;

use Umbrella\AFCTokenBundle\RefreshTokenInterface;
use Umbrella\AFCTokenBundle\TokenInterface;
use Umbrella\AFCTokenBundle\Lib\JCDateTime;
use Umbrella\AFCTokenBundle\Lib\JCHelper;

/**
 * Class Token
 *
 * @package App\v1
 *
 * @method setSalt(string $salt) :Token
 * @method setRefreshTokenHash(string $rth) :Token
 * @method setAt(JCDateTime $at) :Token
 */
class Token implements TokenInterface
{
	/**
	 * @var bool
	 */
	private $isAuthenticated = false;
	/**
	 * @var string
	 */
	private $resource;
	/**
	 * @var int
	 */
	private $ttl;
	/**
	 * @var \Umbrella\AFCTokenBundle\Lib\JCDateTime
	 */
	private $at;
	/**
	 * @var string
	 */
	private $salt;
	/**
	 * @var \Umbrella\AFCTokenBundle\RefreshTokenInterface|null
	 */
	private $RefreshToken;


	/**
	 * Token constructor.
	 *
	 * @param string                             $resource
	 * @param int                                $ttl
	 * @param \Umbrella\AFCTokenBundle\RefreshTokenInterface|null $RefreshToken
	 * @throws \Exception
	 */
	public function __construct(string $resource, int $ttl, RefreshTokenInterface $RefreshToken = null){
		$this->resource = $resource;
		$this->ttl      = $ttl;
		$this->at       = new JCDateTime();
		$this->salt     = JCHelper::generateCryptCode();

		$this->RefreshToken = $RefreshToken;
	}

	/**
	 * @param $methodName
	 * @param $args
	 * @return \Umbrella\AFCTokenBundle\Entity\Token
	 * @throws \Exception
	 */
	public function __call($methodName, $args) :Token{

		if ($this->isAuthenticated){
			throw new \Exception("It's not possible to change data of authenticated token.");
		}

		$methodName = '_' . $methodName;

		return $this->$methodName(...$args);
	}

	/**
	 * @return bool
	 */
	public function isAuthenticated(): bool {
		return $this->isAuthenticated;
	}

	/**
	 * @return \Umbrella\AFCTokenBundle\TokenInterface
	 */
	public function authenticate() :TokenInterface{
		$this->isAuthenticated = true;
		return $this;
	}

	/**
	 * @param \Umbrella\AFCTokenBundle\RefreshTokenInterface $RefreshToken
	 * @return bool
	 * @throws \Exception
	 */
	public function isValidRefreshToken(RefreshTokenInterface $RefreshToken): bool {

		return $this->RefreshToken
			&& $this->RefreshToken->generateHash($this) == $RefreshToken->generateHash($this);
	}

	/**
	 * @return string
	 */
	public function getRefreshHash(): string {
		return $this->RefreshToken->generateHash($this);
	}

	/**
	 * @return string
	 */
	public function getResource(): string {
		return $this->resource;
	}

	/**
	 * @return int
	 */
	public function getTtl(): int {
		return $this->ttl;
	}

	/**
	 * @return \Umbrella\AFCTokenBundle\Lib\JCDateTime
	 */
	public function getAt(): JCDateTime {
		return $this->at;
	}

	/**
	 * @return string
	 */
	public function getSalt(): string {
		return $this->salt;
	}

	/**
	 * @return array
	 */
	public function getSharedData(): array {
		return [];
	}

	/**
	 * @return array
	 * @throws \Exception
	 */
	public function getEncryptedData(): array {
		return [
			'rnd'       => JCHelper::generateCryptCode(32),
			'resource'  => $this->getResource(),
			'at'        => $this->getAt(),
			'ttl'       => $this->getTtl()
		];
	}

	/**
	 * @param \Umbrella\AFCTokenBundle\Lib\JCDateTime $at
	 * @return Token
	 */
	private function _setAt(JCDateTime $at) :Token {
		$this->at = $at;

		return $this;
	}

	/**
	 * @param string $salt
	 * @return Token
	 */
	private function _setSalt(string $salt) :Token {
		$this->salt = $salt;

		return $this;
	}
}