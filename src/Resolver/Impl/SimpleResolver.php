<?php declare(strict_types = 1);

namespace Contributte\Nextras\Orm\Generator\Resolver\Impl;

use Contributte\Nextras\Orm\Generator\Config\Config;
use Contributte\Nextras\Orm\Generator\Entity\Table;
use Contributte\Nextras\Orm\Generator\Resolver\IEntityResolver;
use Contributte\Nextras\Orm\Generator\Resolver\IFacadeResolver;
use Contributte\Nextras\Orm\Generator\Resolver\IFilenameResolver;
use Contributte\Nextras\Orm\Generator\Resolver\IMapperResolver;
use Contributte\Nextras\Orm\Generator\Resolver\IModelResolver;
use Contributte\Nextras\Orm\Generator\Resolver\IRepositoryResolver;
use Contributte\Nextras\Orm\Generator\Utils\Helpers;
use Doctrine\Inflector\InflectorFactory;

abstract class SimpleResolver implements IEntityResolver, IRepositoryResolver, IMapperResolver, IFacadeResolver, IModelResolver
{

	/** @var Config */
	protected $config;

	public function __construct(Config $config)
	{
		$this->config = $config;
	}

	public function resolveFilename(string $name, ?string $folder = null): string
	{
		return ($folder ? $folder . Helpers::DS : null) . $this->normalize(ucfirst($name)) . '.' . IFilenameResolver::PHP_EXT;
	}

	protected function normalize(string $name): string
	{
		// Strip m:n delimiters
		$name = Helpers::stripMnDelimiters($name, '_');

		// Convert to camelCase
		$name = Helpers::camelCase($name);

		return $name;
	}

	protected function table(Table $table, bool $singularize = false): string
	{
		$name = $this->normalize(ucfirst($table->getName()));

		if ($singularize) {
			$name = InflectorFactory::create()->build()->singularize($name);
		}

		return $name;
	}

	public function resolveModelName(): string
	{
		return $this->config->get('model.name');
	}

	public function resolveModelNamespace(): string
	{
		return $this->config->get('model.namespace');
	}

	public function resolveModelFilename(): string
	{
		return $this->config->get('model.filename');
	}

}
