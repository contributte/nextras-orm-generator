<?php

namespace Minetro\Normgen\Utils;

/**
 * Most of this snippets taken from cool Nette Framework
 *
 * @copyright Copyright (c) 2004 David Grudl (http://davidgrudl.com)
 */
class Helpers
{
    /** Namespace separator */
    const NS = '\\';

    /** Directory separator */
    const DS = DIRECTORY_SEPARATOR;

    /** @var array */
    public static $typePatterns = array(
        '^_' => ColumnTypes::TYPE_TEXT, // PostgreSQL arrays
        'BYTEA|BLOB|BIN' => ColumnTypes::TYPE_TEXT,
        'TEXT|CHAR|POINT|INTERVAL' => ColumnTypes::TYPE_TEXT,
        'YEAR|BYTE|COUNTER|SERIAL|INT|LONG|SHORT|^TINY$' => ColumnTypes::TYPE_INTEGER,
        'CURRENCY|REAL|MONEY|FLOAT|DOUBLE|DECIMAL|NUMERIC|NUMBER' => ColumnTypes::TYPE_FLOAT,
        '^TIME$' => ColumnTypes::TYPE_TIME,
        'TIME' => ColumnTypes::TYPE_DATETIME, // DATETIME, TIMESTAMP
        'DATE' => ColumnTypes::TYPE_DATE,
        'BOOL' => ColumnTypes::TYPE_BOOL,
    );

    /** @var array */
    public static $mnDelimiters = [
        '_to_', '_has_', '_x_'
    ];

    /**
     * @param string $s
     * @return string
     */
    public static function camelCase($s)
    {
        $s = preg_replace('#[^a-zA-Z0-9_-]#', ' ', $s);
        $s = preg_replace('#[_-](?=[a-z])#', ' ', $s);
        $s = substr(ucwords('x' . $s), 1);
        $s = str_replace(' ', '', $s);
        return $s;
    }

    /**
     * @param string $type
     * @return mixed
     */
    public static function columnType($type)
    {
        static $cache;
        if (!isset($cache[$type])) {
            $cache[$type] = 'string';
            foreach (self::$typePatterns as $s => $val) {
                if (preg_match("#$s#i", $type)) {
                    return $cache[$type] = $val;
                }
            }
        }
        return $cache[$type];
    }

    /**
     * @param string $s
     * @param string $r
     * @return string
     */
    public static function stripMnDelimiters($s, $r = NULL)
    {
        return str_replace(self::$mnDelimiters, $r, $s);
    }

}
