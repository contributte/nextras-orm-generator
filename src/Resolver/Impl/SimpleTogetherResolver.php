<?php

namespace Minetro\Normgen\Resolver\Impl;

use Doctrine\Common\Inflector\Inflector;
use Minetro\Normgen\Entity\Table;
use Minetro\Normgen\Resolver\IFilenameResolver;
use Minetro\Normgen\Utils\Helpers;

class SimpleTogetherResolver extends SimpleResolver
{

    /**
     * @param Table $table
     * @return string
     */
    public function resolveEntityName(Table $table)
    {
		return $this->resolveName('entity', $table);
    }

    /**
     * @param Table $table
     * @return string
     */
    public function resolveEntityNamespace(Table $table)
    {
        return $this->config->get('orm.namespace') . Helpers::NS . $this->table($table, $this->config->get('orm.singularize'));
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
		return $this->resolveName('repository', $table);
    }

    /**
     * @param Table $table
     * @return string
     */
    public function resolveRepositoryNamespace(Table $table)
    {
        return $this->config->get('orm.namespace') . Helpers::NS . $this->table($table);
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
		return $this->resolveName('mapper', $table);
    }

    /**
     * @param Table $table
     * @return string
     */
    public function resolveMapperNamespace(Table $table)
    {
        return $this->config->get('orm.namespace') . Helpers::NS . $this->table($table, $this->config->get('orm.singularize'));
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
    public function resolveFacadeName(Table $table)
    {
    	return $this->resolveName('facade', $table);
    }

	/**
	 * @param string $type (entity,repository,mapper,facade)
	 * @param $table
	 * @return string
	 */
    protected function resolveName($type, Table $table)
	{
		$name = ucfirst($table->getName());
		if($this->config->get($type . '.name.singularize')) {
			$name = Inflector::singularize($name);
		}
		$name .= $this->config->get( $type . '.name.suffix');
		return $this->normalize($name);
	}

	/**
	 * @param string $type
	 * @param Table $table
	 * @return string
	 */
	protected function resolveFilenameFor($type, Table $table)
	{
		$folder = $this->table($table, $this->config->get('orm.singularize'));
		$name = ucfirst($table->getName());
		if($this->config->get($type . '.name.singularize')) {
			$name = Inflector::singularize($name);
		}
		$filename = $this->normalize($name . $this->config->get($type . '.filename.suffix')) . '.' . IFilenameResolver::PHP_EXT;
		return $folder . Helpers::DS . $filename;
	}

    /**
     * @param Table $table
     * @return string
     */
    public function resolveFacadeNamespace(Table $table)
    {
        return $this->config->get('orm.namespace') . Helpers::NS . $this->table($table);
    }

    /**
     * @param Table $table
     * @return string
     */
    public function resolveFacadeFilename(Table $table)
    {
        return $this->resolveFilenameFor('facade', $table);
    }

}
