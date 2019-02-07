<?php

namespace Contributte\Nextras\Orm\Generator\Resolver\Impl;

use Doctrine\Common\Inflector\Inflector;
use Contributte\Nextras\Orm\Generator\Config\Config;
use Contributte\Nextras\Orm\Generator\Entity\Table;
use Contributte\Nextras\Orm\Generator\Resolver\IEntityResolver;
use Contributte\Nextras\Orm\Generator\Resolver\IFacadeResolver;
use Contributte\Nextras\Orm\Generator\Resolver\IFilenameResolver;
use Contributte\Nextras\Orm\Generator\Resolver\IMapperResolver;
use Contributte\Nextras\Orm\Generator\Resolver\IRepositoryResolver;
use Contributte\Nextras\Orm\Generator\Utils\Helpers;

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
    protected function table(Table $table, $singularize = FALSE)
    {
        $name = $this->normalize(ucfirst($table->getName()));

        if ($singularize) {
				$name = Inflector::singularize($name);
			}
        return $name;
    }
}
