<?php

namespace AFCTokenBundle\Service\CryptKey\Exception;

use AFCTokenBundle\Exception\AFCTokenException;

/**
 * Class NoEncryptionKeyFileException
 *
 * @package Service\CryptKey\Exception
 */
class NoEncryptionKeyFileException extends AFCTokenException
{
	const MESSAGE = 'Encryption key-file not found.';
}