<?php

namespace Contributte\Nextras\Orm\Generator\Resolver\Impl;

use Doctrine\Common\Inflector\Inflector;
use Contributte\Nextras\Orm\Generator\Entity\Table;
use Contributte\Nextras\Orm\Generator\Resolver\IFilenameResolver;

class SimpleSeparateResolver extends SimpleResolver
{

    /**
     * @param Table $table
     * @return string
     */
    public function resolveEntityName(Table $table)
    {
    	return $this->resolveNameFor('entity', $table);
    }

    /**
     * @param Table $table
     * @return string
     */
    public function resolveEntityNamespace(Table $table)
    {
        return $this->config->get('entity.namespace');
    }

    /**
     * @param Table $table
     * @return string
     */
    public function resolveEntityFilename(Table $table)
    {
		return $this->resolveFilenameFor('entity', $table);
    }

    /**
     * @param Table $table
     * @return string
     */
    public function resolveRepositoryName(Table $table)
    {
		return $this->resolveNameFor('repository', $table);
    }

    /**
     * @param Table $table
     * @return string
     */
    public function resolveRepositoryNamespace(Table $table)
    {
        return $this->config->get('repository.namespace');
    }

    /**
     * @param Table $table
     * @return string
     */
    public function resolveRepositoryFilename(Table $table)
    {
		return $this->resolveFilenameFor('repository', $table);
    }

    /**
     * @param Table $table
     * @return string
     */
    public function resolveMapperName(Table $table)
    {
		return $this->resolveNameFor('mapper', $table);
    }

    /**
     * @param Table $table
     * @return string
     */
    public function resolveMapperFilename(Table $table)
    {
		return $this->resolveFilenameFor('mapper', $table);
    }

    /**
     * @param Table $table
     * @return string
     */
    public function resolveMapperNamespace(Table $table)
    {
        return $this->config->get('mapper.namespace');
    }

    /**
     * @param Table $table
     * @return string
     */
    public function resolveFacadeName(Table $table)
    {
    	return $this->resolveNameFor('facade', $table);
    }

    /**
     * @param Table $table
     * @return string
     */
    public function resolveFacadeNamespace(Table $table)
    {
        return $this->config->get('facade.namespace');
    }

    /**
     * @param Table $table
     * @return string
     */
    public function resolveFacadeFilename(Table $table)
    {
    	return $this->resolveFilenameFor('facade', $table);
    }

	/**
	 * @param $tpe
	 * @param Table $table
	 * @return string
	 */
    protected function resolveFilenameFor($type, Table $table)
	{
		$name = $this->normalize(ucfirst($table->getName()));
		if($this->config->get($type . '.name.singularize')) {
			$name = Inflector::singularize($name);
		}
		$name .= $this->config->get($type . '.filename.suffix');
		return $this->config->get($type . '.folder') . DIRECTORY_SEPARATOR . $name . '.' . IFilenameResolver::PHP_EXT;
	}

	/**
	 * @param $type
	 * @param Table $table
	 * @return string
	 */
	protected function resolveNameFor($type, Table $table)
	{
		$name = $this->normalize(ucfirst($table->getName()));
		if($this->config->get($type . '.name.singularize')) {
			$name = Inflector::singularize($name);
		}
		$name .= $this->config->get($type . '.name.suffix');
		return $name;
	}
}
