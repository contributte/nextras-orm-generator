<?php

namespace Minetro\Normgen\Resolver\Impl;

use Minetro\Normgen\Config\Config;
use Minetro\Normgen\Entity\Table;
use Minetro\Normgen\Resolver\IEntityResolver;
use Minetro\Normgen\Resolver\IFacadeResolver;
use Minetro\Normgen\Resolver\IFilenameResolver;
use Minetro\Normgen\Resolver\IMapperResolver;
use Minetro\Normgen\Resolver\IRepositoryResolver;
use Minetro\Normgen\Utils\Helpers;

abstract class SimpleResolver implements IEntityResolver, IRepositoryResolver, IMapperResolver, IFacadeResolver
{

    /** @var Config */
    protected $config;

    /**
     * @param Config $config
     */
    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    /**
     * @param string $name
     * @param string $folder
     * @return string
     */
    public function resolveFilename($name, $folder = NULL)
    {
        return ($folder ? $folder . Helpers::DS : NULL) . $this->normalize(ucfirst($name)) . '.' . IFilenameResolver::PHP_EXT;
    }

    /**
     * @param string $name
     * @return string
     */
    protected function normalize($name)
    {
        // Strip m:n delimiters
        $name = Helpers::stripMnDelimiters($name, '_');

        // Convert to camelCase
        $name = Helpers::camelCase($name);

        return $name;
    }

    /**
     * @param Table $table
     * @return string
     */
    protected function table(Table $table)
    {
        return $this->normalize(ucfirst($table->getName()));
    }
}
