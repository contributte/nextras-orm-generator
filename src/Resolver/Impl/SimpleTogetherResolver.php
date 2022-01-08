<?php declare(strict_types = 1);

namespace Contributte\Nextras\Orm\Generator\Resolver\Impl;

use Contributte\Nextras\Orm\Generator\Entity\Table;
use Contributte\Nextras\Orm\Generator\Resolver\IFilenameResolver;
use Contributte\Nextras\Orm\Generator\Utils\Helpers;
use Doctrine\Inflector\InflectorFactory;

class SimpleTogetherResolver extends SimpleResolver
{

	public function resolveEntityName(Table $table): string
	{
		return $this->resolveName('entity', $table);
	}

	public function resolveEntityNamespace(Table $table): string
	{
		return $this->config->get('orm.namespace') . Helpers::NS . $this->table($table, $this->config->get('orm.singularize'));
	}

	public function resolveEntityFilename(Table $table): string
	{
		return $this->resolveFilenameFor('entity', $table);
	}

	public function resolveRepositoryName(Table $table): string
	{
		return $this->resolveName('repository', $table);
	}

	public function resolveRepositoryNamespace(Table $table): string
	{
		return $this->config->get('orm.namespace') . Helpers::NS . $this->table($table);
	}

	public function resolveRepositoryFilename(Table $table): string
	{
		return $this->resolveFilenameFor('repository', $table);
	}

	public function resolveMapperName(Table $table): string
	{
		return $this->resolveName('mapper', $table);
	}

	public function resolveMapperNamespace(Table $table): string
	{
		return $this->config->get('orm.namespace') . Helpers::NS . $this->table($table, $this->config->get('orm.singularize'));
	}

	public function resolveMapperFilename(Table $table): string
	{
		return $this->resolveFilenameFor('mapper', $table);
	}

	public function resolveFacadeName(Table $table): string
	{
		return $this->resolveName('facade', $table);
	}

	/**
	 * @param string $type (entity,repository,mapper,facade)
	 */
	protected function resolveName(string $type, Table $table): string
	{
		$name = ucfirst($table->getName());
		if (!empty($this->config->get($type . '.name.singularize'))) {
			$name = InflectorFactory::create()->build()->singularize($name);
		}

		$name .= $this->config->get($type . '.name.suffix');
		return $this->normalize($name);
	}

	protected function resolveFilenameFor(string $type, Table $table): string
	{
		$folder = $this->table($table, $this->config->get('orm.singularize'));
		$name = ucfirst($table->getName());
		if (!empty($this->config->get($type . '.name.singularize'))) {
			$name = InflectorFactory::create()->build()->singularize($name);
		}

		$filename = $this->normalize($name . $this->config->get($type . '.filename.suffix')) . '.' . IFilenameResolver::PHP_EXT;
		return $folder . Helpers::DS . $filename;
	}

	public function resolveFacadeNamespace(Table $table): string
	{
		return $this->config->get('orm.namespace') . Helpers::NS . $this->table($table);
	}

	public function resolveFacadeFilename(Table $table): string
	{
		return $this->resolveFilenameFor('facade', $table);
	}

}
