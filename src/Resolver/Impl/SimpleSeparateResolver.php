<?php declare(strict_types = 1);

namespace Contributte\Nextras\Orm\Generator\Resolver\Impl;

use Contributte\Nextras\Orm\Generator\Entity\Table;
use Contributte\Nextras\Orm\Generator\Resolver\IFilenameResolver;
use Doctrine\Inflector\InflectorFactory;

class SimpleSeparateResolver extends SimpleResolver
{

	public function resolveEntityName(Table $table): string
	{
		return $this->resolveNameFor('entity', $table);
	}

	public function resolveEntityNamespace(Table $table): string
	{
		return $this->config->get('entity.namespace');
	}

	public function resolveEntityFilename(Table $table): string
	{
		return $this->resolveFilenameFor('entity', $table);
	}

	public function resolveRepositoryName(Table $table): string
	{
		return $this->resolveNameFor('repository', $table);
	}

	public function resolveRepositoryNamespace(Table $table): string
	{
		return $this->config->get('repository.namespace');
	}

	public function resolveRepositoryFilename(Table $table): string
	{
		return $this->resolveFilenameFor('repository', $table);
	}

	public function resolveMapperName(Table $table): string
	{
		return $this->resolveNameFor('mapper', $table);
	}

	public function resolveMapperFilename(Table $table): string
	{
		return $this->resolveFilenameFor('mapper', $table);
	}

	public function resolveMapperNamespace(Table $table): string
	{
		return $this->config->get('mapper.namespace');
	}

	public function resolveFacadeName(Table $table): string
	{
		return $this->resolveNameFor('facade', $table);
	}

	public function resolveFacadeNamespace(Table $table): string
	{
		return $this->config->get('facade.namespace');
	}

	public function resolveFacadeFilename(Table $table): string
	{
		return $this->resolveFilenameFor('facade', $table);
	}

	/**
	 * @param string $type type of object to generate (entity, repository, mapper...)
	 */
	protected function resolveFilenameFor(string $type, Table $table): string
	{
		$name = $this->normalize(ucfirst($table->getName()));
		if (!empty($this->config->get($type . '.name.singularize'))) {
			$name = InflectorFactory::create()->build()->singularize($name);
		}

		$name .= $this->config->get($type . '.filename.suffix');
		return $this->config->get($type . '.folder') . DIRECTORY_SEPARATOR . $name . '.' . IFilenameResolver::PHP_EXT;
	}

	protected function resolveNameFor(string $type, Table $table): string
	{
		$name = $this->normalize(ucfirst($table->getName()));
		if (!empty($this->config->get($type . '.name.singularize'))) {
			$name = InflectorFactory::create()->build()->singularize($name);
		}

		return $name . $this->config->get($type . '.name.suffix');
	}

}
