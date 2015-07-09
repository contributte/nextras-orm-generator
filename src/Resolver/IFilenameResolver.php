<?php

namespace Minetro\Resolver;

interface IFilenameResolver
{

    /**
     * @param string $name
     * @return string
     */
    function resolveFilename($name);
}