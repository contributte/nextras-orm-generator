<?php

namespace Minetro\Resolver;

use Minetro\Normgen\Config;
use Minetro\Normgen\Entity\Table;
use Minetro\Normgen\Utils\Helpers;

class SimpleResolver implements IEntityResolver, IRepositoryResolver, IMapperResolver, IFacadeResolver
{
    /** Constants */
    const PHP_EXT = 'php';

    /** @var Config */
    private $config;

    /**
     * @param Config $config
     */
    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    /**
     * @param string $name
     * @return string
     */
    public function resolveFilename($name)
    {
        return $this->normalize(ucfirst($name)) . '.php';
    }

    /**
     * @param Table $table
     * @return string
     */
    public function resolveEntityName(Table $table)
    {
        return $this->normalize(ucfirst($table->getName()) . $this->config->get('entity.name.suffix'));
    }

    /**
     * @param Table $table
     * @return string
     */
    public function resolveEntityFilename(Table $table)
    {
        return $this->normalize(ucfirst($table->getName()) . $this->config->get('entity.filename.suffix')) . '.php';
    }

    /**
     * @param Table $table
     * @return string
     */
    public function resolveRepositoryName(Table $table)
    {
        return $this->normalize(ucfirst($table->getName()) . $this->config->get('repository.name.suffix'));
    }

    /**
     * @param Table $table
     * @return string
     */
    public function resolveRepositoryFilename(Table $table)
    {
        return $this->normalize(ucfirst($table->getName()) . $this->config->get('repository.filename.suffix')) . '.php';
    }

    /**
     * @param Table $table
     * @return string
     */
    public function resolveMapperName(Table $table)
    {
        return $this->normalize(ucfirst($table->getName()) . $this->config->get('mapper.name.suffix'));
    }

    /**
     * @param Table $table
     * @return string
     */
    public function resolveMapperFilename(Table $table)
    {
        return $this->normalize(ucfirst($table->getName()) . $this->config->get('mapper.filename.suffix')) . '.php';
    }

    /**
     * @param Table $table
     * @return string
     */
    public function resolveFacadeName(Table $table)
    {
        return $this->normalize(ucfirst($table->getName()) . $this->config->get('facade.name.suffix'));
    }

    /**
     * @param Table $table
     * @return string
     */
    public function resolveFacadeFilename(Table $table)
    {
        return $this->normalize(ucfirst($table->getName()) . $this->config->get('facade.filename.suffix')) . '.php';
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

}
