<?php declare(strict_types = 1);

namespace Contributte\Nextras\Orm\Generator\Utils;

/**
 * Most of this snippets taken from cool Nette Framework
 */
class Helpers
{

	/**
	 * Namespace separator
	 */
	public const NS = '\\';

	/**
	 * Directory separator
	 */
	public const DS = DIRECTORY_SEPARATOR;

	/** @var string[] */
	public static $typePatterns = [
		'^_' => ColumnTypes::TYPE_TEXT, // PostgreSQL arrays
		'BYTEA|BLOB|BIN' => ColumnTypes::TYPE_TEXT,
		'TEXT|CHAR|POINT|INTERVAL' => ColumnTypes::TYPE_TEXT,
		'YEAR|BYTE|COUNTER|SERIAL|INT|LONG|SHORT|^TINY$' => ColumnTypes::TYPE_INTEGER,
		'CURRENCY|REAL|MONEY|FLOAT|DOUBLE|DECIMAL|NUMERIC|NUMBER' => ColumnTypes::TYPE_FLOAT,
		'^TIME$' => ColumnTypes::TYPE_TIME,
		'TIME' => ColumnTypes::TYPE_DATETIME, // DATETIME, TIMESTAMP
		'DATE' => ColumnTypes::TYPE_DATE,
		'BOOL' => ColumnTypes::TYPE_BOOL,
	];

	/** @var string[] */
	public static $mnDelimiters = [
		'_to_',
		'_has_',
		'_x_',
	];

	public static function camelCase(string $s): string
	{
		$s = trim($s);
		$s = (string) preg_replace('#[^a-zA-Z0-9_-]#', ' ', $s);
		$s = (string) preg_replace('#[_-](?=[a-z])#', ' ', $s);
		$s = substr(ucwords('x' . $s), 1);
		$s = str_replace(' ', '', $s);
		return $s;
	}

	public static function columnType(string $type): string
	{
		static $cache;
		if (!isset($cache[$type])) {
			$cache[$type] = 'string';
			foreach (self::$typePatterns as $s => $val) {
				if (preg_match('#' . $s . '#i', $type)) {
					return $cache[$type] = $val;
				}
			}
		}

		return $cache[$type];
	}

	public static function stripMnDelimiters(string $s, ?string $r = null): string
	{
		return str_replace(self::$mnDelimiters, (string) $r, $s);
	}

}
