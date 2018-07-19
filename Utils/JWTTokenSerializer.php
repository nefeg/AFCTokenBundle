<?php
/**
 * Created by PhpStorm.
 * User: omni
 * Date: 20.06.2018
 * Time: 15:48
 */

namespace Umbrella\AFCTokenBundle\Utils;


use Umbrella\AFCTokenBundle\Entity\RefreshTokenHash;
use Umbrella\AFCTokenBundle\Entity\Token;
use Umbrella\AFCTokenBundle\TokenInterface;
use App\Lib\JCEncrypter;

use Firebase\JWT\JWT;

/**
 * Class JWTTokenSerializer
 *
 * @package Umbrella\AFCTokenBundle\Service
 */
class JWTTokenSerializer
{
	private const TYPE = 'HS512';

	static public function ArraySerialize(TokenInterface $Token, string $privateKey = null) :array{
		$privateKey = <<<EOD
-----BEGIN RSA PRIVATE KEY-----
MIIEpAIBAAKCAQEAxWHdDABtTnOq+PNENVABuHT4QXAsOwvshgfUj7mEcZhd1y4j
s67OKa9nFMV9OvHrn0qs4Bmr0HhwzLhWGkMxD/yMLU9WotdkGSwueHs8plmUjqNf
6m9E9D5GvanC9hwB2gES9VIxyT/AwoHusg5JpwS9sB1jJKl5unh3MASRzD1ckhQD
BGW2ND3tW/UNIGwIHi4jKGLPlJNeUC0VN6e/XaUgdyFpbmgFbsUHcl3AnJQv8HYj
eNyBMokbIdSXW7w7XOHySPkAgxKKrT1yHa0eH7YbNj3fTJ5npa3JYs0lcqg0rB1F
hLrFEczhl7lSYWmDCMEwJ7iIuCm5xT87ZwqM5wIDAQABAoIBAAh3UR7hqc6SoYO6
E3Ph8aDyy28rG4qQ0V1SWqirgWXJ7kR7gyaC2e7pyhcW/W8Yz01uy4l1MGxprhTp
1y+bMDCKWYzb+VBUwsNdpMSgLJLKBtgzY7rPePqs7SXXcThTLTUnlKOXGfGS3Xa6
Uf2rJTeXuXcjW4xIBKOd5SbXG1XSPJiWt2dwmANrkcIMnfdu7okcIPfsKQ68juzf
A9SMOCbGLoNYeqEAsr9A/We8jxuZtwnhy/shUGbXGd1N63u63QGLoJD7jfjjXZXO
Cqsdt2r0aRRt2Md4k1jEYUHLpeNVzgaB/OMnwTYLnATBVp3cWb8bwDQgbJncWWrX
YcMMQFECgYEA9f82LCPpdmsD7KASsKER/zbH8GOWP5AkOYnaHT+4mbnXdSSGf0Rx
vUD5JG5UFY+PKg2Kg9KbFP0r0OfVXLolvrtAXSoQA4UWGPty1lCX1p2Gh9PeXtUY
pjT4VVsIRiBxWncXZw7igSMRnn/q7FTm1KDGhJM4bB7lMZzzSEAyOi8CgYEAzWiU
zR47RkAz+djm0oVH0s3WwTLkVXfbF+UFOKsoL0tAkwzBKrBxnVWeSpaS7RAKhSYl
SK74syN4ACYpx0bCOZDoVZa/jh5gZZEKOVbWkvHyAjtmxL20rHZ4naI71vG1Cyy7
+X7NZQJrS811wLy8RhabkFxvSdW+RKgWWGIhgskCgYEAlMLRL8BH3qS4qs/ifY3q
JDwsjOKsaaPxRBppHGb8a3pHIUAFVdE+NwSjpbRShPdbzEKEEVO7FOZFKQAJtxma
2czDD5PwOzCwPEtTFueF6vM398vYHeEgFuLRikySpFXaNqruLBSERTO/4+nXVzPA
o7TWWDXvWPMWBvqy5G5t8WECgYEAq/aL7JUMpqmFWfv+cexmztLIoYHLqsnmwEBZ
eLHBuKZVb0ZUSTriQwe0t1kLtC+jvwjKWekyCDb/dZB9lXlljPAFsfG8eGxx41Xj
q1FJ3kdzhe7ZAIiZQ3EDVWTGmBJOsQZIcH150sCNty5REIRxUnQG1HquKLAq1Cus
WV3+FBECgYBQ1MOgUmhPGVp1vswPLUMMl7ylwX4MUr+6bT53uh6DvuFtjk1AYBPE
9UsV7J7z115kulS6NrcEK7bAENta/1iSl4dRIzXGgyvtEbbPHr2sulq12esp7FP7
rEQFWy2Ygkud0KcEseTs14Qp4jNSgIaSabfk40zrZ6jz7l0+mW/WWw==
-----END RSA PRIVATE KEY-----
EOD;

		return [
			'exp'       => $Token->getAt()->modify('+'. $Token->getTtl() . ' seconds')->getTimestamp(),
			'salt'      => $Token->getSalt(),
			'shared'    => $Token->getSharedData(),
			'crypt'     => JCEncrypter::encrypt_RSA(json_encode($Token->getEncryptedData()), $privateKey),
			'refresh'   => $Token->getRefreshHash(),
		];
	}

	/**
	 * !Key must be in .pem format
	 * @param \Umbrella\AFCTokenBundle\TokenInterface $Token
	 * @param string                             $secret
	 * @param string                             $privateKey
	 * @return string
	 */
	static public function serialize(TokenInterface $Token, string $secret = null, string $privateKey = null): string {

		$secret    = '6fdc9797d3897904dee51e7f1761d92f';

		$jwt = JWT::encode(static::ArraySerialize($Token, $privateKey), $secret, static::TYPE);

		return $jwt;
	}

	/**
	 * !Key must be in .pem format
	 *
	 * @param string $tokenString
	 * @param string $secret
	 * @param string $publicKey
	 * @return \Umbrella\AFCTokenBundle\TokenInterface
	 * @throws \Exception
	 */
	static public function deserialize(string $tokenString, string $secret = null, string $publicKey = null): TokenInterface {

	$publicKey = <<<EOD
-----BEGIN PUBLIC KEY-----
MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAxWHdDABtTnOq+PNENVAB
uHT4QXAsOwvshgfUj7mEcZhd1y4js67OKa9nFMV9OvHrn0qs4Bmr0HhwzLhWGkMx
D/yMLU9WotdkGSwueHs8plmUjqNf6m9E9D5GvanC9hwB2gES9VIxyT/AwoHusg5J
pwS9sB1jJKl5unh3MASRzD1ckhQDBGW2ND3tW/UNIGwIHi4jKGLPlJNeUC0VN6e/
XaUgdyFpbmgFbsUHcl3AnJQv8HYjeNyBMokbIdSXW7w7XOHySPkAgxKKrT1yHa0e
H7YbNj3fTJ5npa3JYs0lcqg0rB1FhLrFEczhl7lSYWmDCMEwJ7iIuCm5xT87ZwqM
5wIDAQAB
-----END PUBLIC KEY-----
EOD;

		$secret    = '6fdc9797d3897904dee51e7f1761d92f';


		$tokenData = JWT::decode($tokenString, $secret, [static::TYPE]);

		$decryptedData = json_decode(JCEncrypter::decrypt_RSA($tokenData->crypt, $publicKey));

		$Token = new Token(
			$decryptedData->resource,
			$decryptedData->ttl,
			new RefreshTokenHash($tokenData->refresh)
		);

//		$Token->setAt($decryptedData->at);
		$Token->setSalt($tokenData->salt);

		return $Token;
	}
}