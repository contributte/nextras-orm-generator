<?php declare(strict_types = 1);

namespace Contributte\Nextras\Orm\Generator\Utils;

interface ColumnTypes
{

	// Natives

	public const NATIVE_TYPE_ENUM = 'ENUM';

	// Native regexs

	public const NATIVE_REGEX_ENUM = '#\'(.*)\'#U';

	// Others

	public const TYPE_TEXT = 'string';
	public const TYPE_INTEGER = 'int';
	public const TYPE_FLOAT = 'float';
	public const TYPE_BOOL = 'bool';
	public const TYPE_ENUM = 'enum';
	public const TYPE_DATE = 'date';
	public const TYPE_TIME = 'time';
	public const TYPE_DATETIME = 'datetime';
	public const TYPE_UNIX_TIMESTAMP = 'timestamp';
	public const TYPE_TIME_INTERVAL = 'timeint';

}
