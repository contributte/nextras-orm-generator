<?php

namespace Contributte\Nextras\Orm\Generator\Resolver;

interface IFilenameResolver
{

    /** Constants */
    const PHP_EXT = 'php';

    /**
     * @param string $name
     * @param string $folder [optional]
     * @return string
     */
    function resolveFilename($name, $folder = NULL);
}