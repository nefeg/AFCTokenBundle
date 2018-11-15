<?php
/**
 * Created by PhpStorm.
 * User: omni
 * Date: 26.06.2018
 * Time: 2:33
 */

namespace Umbrella\AFCTokenBundle\Entity;

use Umbrella\AFCTokenBundle\Exception\TokenImmutableDataException;
use Umbrella\AFCTokenBundle\Exception\TokenConstructorFailException;
use Umbrella\AFCTokenBundle\RefreshTokenInterface;
use Umbrella\AFCTokenBundle\TokenInterface;
use Umbrella\JCLibPack\JCDateTime;
use Umbrella\JCLibPack\JCHelper;

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
	 * @var \Umbrella\JCLibPack\JCDateTime
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
	 * @var string crypt-filler
	 */
	private $_filler;


	/**
	 * Token constructor.
	 *
	 * @param string                                              $resource
	 * @param int                                                 $ttl
	 * @param \Umbrella\AFCTokenBundle\RefreshTokenInterface|null $RefreshToken
	 * @throws \Umbrella\AFCTokenBundle\Exception\TokenConstructorFailException
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
	 * @return \Umbrella\AFCTokenBundle\Entity\Token
	 * @throws \Umbrella\AFCTokenBundle\Exception\TokenImmutableDataException
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
	 * @return \Umbrella\AFCTokenBundle\TokenInterface
	 */
	public function authorize() :TokenInterface{
		$this->isAuthorized = true;
		return $this;
	}

	/**
	 * @return bool
	 */
	public function isExpired() :bool{
		return time() - ( $this->getTtl() + $this->getAt()->getTimestamp() ) <= 0;
	}

	/**
	 * @param \Umbrella\AFCTokenBundle\RefreshTokenInterface $RefreshToken
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
	 * @return \Umbrella\JCLibPack\JCDateTime
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
	 * @param \Umbrella\JCLibPack\JCDateTime $at
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