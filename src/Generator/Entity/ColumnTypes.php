<?php

namespace Minetro\Normgen\Generator\Entity;

interface ColumnTypes
{

    // Natives

    const NATIVE_TYPE_ENUM = 'ENUM';

    // Native regex

    const NATIVE_REGEX_ENUM = '#\'(.*)\'#U';

    // Others

    const TYPE_TEXT = 'string';
    const TYPE_INTEGER = 'int';
    const TYPE_FLOAT = 'float';
    const TYPE_BOOL = 'bool';
    const TYPE_ENUM = 'enum';
    const TYPE_DATE = 'date';
    const TYPE_TIME = 'time';
    const TYPE_DATETIME = 'datetime';
    const TYPE_UNIX_TIMESTAMP = 'timestamp';
    const TYPE_TIME_INTERVAL = 'timeint';

}