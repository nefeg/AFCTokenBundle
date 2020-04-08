<?php

namespace AFCTokenBundle\Service\CryptKey;

use AFCTokenBundle\Service\CryptKey\Exception\NoEncryptionKeyFileException;
use AFCTokenBundle\Service\CryptKeyInterface;

/**
 * Class FileKey
 *
 * @package Service\CryptKey
 */
class FileKey implements CryptKeyInterface
{
	/**
	 * @var string
	 */
	private $keyPath;

	/**
	 * FileKey constructor.
	 *
	 * @param string $keyPath
	 * @throws NoEncryptionKeyFileException
	 */
	public function __construct(string $keyPath){

		if (!file_exists($keyPath))
			throw new NoEncryptionKeyFileException("", 0, new \Exception('Invalid path: '. $keyPath));

		$this->keyPath = realpath($keyPath);
	}

	/**
	 * @return string
	 */
	public function __toString(): string {
		return file_get_contents($this->keyPath);
	}
}