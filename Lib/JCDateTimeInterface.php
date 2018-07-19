<?php
namespace App\Lib;

/**
 * Interface JCDateTimeInterface
 *
 * @package App\lib
 */
interface JCDateTimeInterface extends JCStringInterface, \DateTimeInterface
{
	/**
	 * @return string
	 */
	public function getStringFormat() :string;

	/**
	 * @param string $stringFormat
	 * @return JCDateTimeInterface
	 */
	public function setStringFormat(string $stringFormat) :JCDateTimeInterface;
}