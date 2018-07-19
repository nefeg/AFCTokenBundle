<?php
/**
 * Created by PhpStorm.
 * User: omni
 * Date: 26.06.2018
 * Time: 23:21
 */

namespace Umbrella\AFCTokenBundle\Entity;

use Umbrella\AFCTokenBundle\RefreshTokenInterface;
use Umbrella\AFCTokenBundle\TokenInterface;


/**
 * Class RefreshTokenCode
 *
 * @package App\v1
 */
class RefreshTokenCode implements RefreshTokenInterface
{
	/**
	 * @var string
	 */
	private $code;

	/**
	 * RefreshToken constructor.
	 *
	 * @param string                 $code
	 */
	public function __construct(string $code){
		$this->code = $code;
	}

	/**
	 * @param \Umbrella\AFCTokenBundle\TokenInterface $Token
	 * @return string
	 */
	public function generateHash(TokenInterface $Token): string {

		$s1 = sha1($this->code . $Token->getSalt());
		$s2 = sha1($Token->getSalt() . $Token->getResource() . /*$Token->getAt() .*/ $Token->getTtl());

		$hash = sha1( $s1 . $s2 );

//		var_dump('<<< Code >>>');
//		var_dump("salt: {$Token->getSalt()};\n code: $this->code;\n");
//		var_dump("s1: $s1;\n s2: $s2;\n sum: $hash");
//		var_dump('<<< /Code >>>');


		return $hash; // $this->refreshTokenHash;
	}

	/**
	 * @return string
	 */
	public function getSource(): string {
		return $this->code;
	}
}