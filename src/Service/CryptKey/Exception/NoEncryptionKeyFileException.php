<?php
/**
 * Created by PhpStorm.
 * User: omni
 * Date: 13.11.2018
 * Time: 19:49
 */

namespace Umbrella\AFCTokenBundle\Service\CryptKey\Exception;

use Umbrella\AFCTokenBundle\Exception\AFCTokenException;

/**
 * Class NoEncryptionKeyFileException
 *
 * @package Service\CryptKey\Exception
 */
class NoEncryptionKeyFileException extends AFCTokenException
{
	const MESSAGE = 'Encryption key-file not found.';
}