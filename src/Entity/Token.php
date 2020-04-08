<?php

namespace AFCTokenBundle\Entity;

use AFCTokenBundle\Exception\TokenImmutableDataException;
use AFCTokenBundle\Exception\TokenConstructorFailException;
use AFCTokenBundle\RefreshTokenInterface;
use AFCTokenBundle\TokenInterface;
use JCLibPack\JCDateTime;
use JCLibPack\JCHelper;

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
	private $isAuthorized = false;
	/**
	 * @var string
	 */
	private $resource;
	/**
	 * @var int
	 */
	private $ttl;
	/**
	 * @var \JCLibPack\JCDateTime
	 */
	private $at;
	/**
	 * @var string
	 */
	private $salt;
	/**
	 * @var \AFCTokenBundle\RefreshTokenInterface|null
	 */
	private $RefreshToken;
	/**
	 * @var string crypt-filler
	 */
	private $_filler;


	/**
	 * Token constructor.
	 *
	 * @param string                                              $resource
	 * @param int                                                 $ttl
	 * @param \AFCTokenBundle\RefreshTokenInterface|null $RefreshToken
	 * @throws \AFCTokenBundle\Exception\TokenConstructorFailException
	 */
	public function __construct(string $resource, int $ttl, RefreshTokenInterface $RefreshToken = null){
		$this->resource     = $resource;
		$this->ttl          = $ttl;
		$this->at           = new JCDateTime();
		$this->RefreshToken = $RefreshToken;

		try {
			$this->salt     = JCHelper::generateCryptCode();
			$this->_filler  = JCHelper::generateCryptCode(32);

		}catch (\Exception $Exception){
			throw new TokenConstructorFailException("crypt-string generation error",0, $Exception);
		}
	}

	/**
	 * @param $methodName
	 * @param $args
	 * @return \AFCTokenBundle\Entity\Token
	 * @throws \AFCTokenBundle\Exception\TokenImmutableDataException
	 */
	public function __call($methodName, $args) :Token{

		if ($this->isAuthorized){
			throw new TokenImmutableDataException();
		}

		$methodName = '_' . $methodName;

		return $this->$methodName(...$args);
	}

	/**
	 * @return bool
	 */
	public function isAuthorized(): bool {
		return $this->isAuthorized;
	}

	/**
	 * @return \AFCTokenBundle\TokenInterface
	 */
	public function authorize() :TokenInterface{
		$this->isAuthorized = true;
		return $this;
	}

	/**
	 * @return bool
	 */
	public function isExpired() :bool{
		return time() > ( $this->getTtl() + $this->getAt()->getTimestamp() );
	}

	/**
	 * @param \AFCTokenBundle\RefreshTokenInterface $RefreshToken
	 * @return bool
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
	 * @return \JCLibPack\JCDateTime
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
	 */
	public function getEncryptedData(): array {

		return [
			'rnd'       => $this->_filler,
			'resource'  => $this->getResource(),
			'at'        => $this->getAt(),
			'ttl'       => $this->getTtl()
		];
	}

	/**
	 * @param \JCLibPack\JCDateTime $at
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