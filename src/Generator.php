<?php declare(strict_types = 1);

namespace Contributte\Nextras\Orm\Generator;

use Contributte\Nextras\Orm\Generator\Analyser\IAnalyser;
use Contributte\Nextras\Orm\Generator\Config\Config;
use Contributte\Nextras\Orm\Generator\Generator\IGenerator;

class Generator
{

	private Config $config;

	private IAnalyser $analyser;

	private IGenerator $entityGenerator;

	private IGenerator $repositoryGenerator;

	private IGenerator $mapperGenerator;

	private IGenerator $facadeGenerator;

	private IGenerator $modelGenerator;

	public function __construct(Config $config, IAnalyser $analyser)
	{
		$this->config = $config;
		$this->analyser = $analyser;
	}

	public function getEntityGenerator(): IGenerator
	{
		return $this->entityGenerator;
	}

	public function setEntityGenerator(IGenerator $generator): void
	{
		$this->entityGenerator = $generator;
	}

	public function getRepositoryGenerator(): IGenerator
	{
		return $this->repositoryGenerator;
	}

	public function setRepositoryGenerator(IGenerator $generator): void
	{
		$this->repositoryGenerator = $generator;
	}

	public function getMapperGenerator(): IGenerator
	{
		return $this->mapperGenerator;
	}

	public function setMapperGenerator(IGenerator $generator): void
	{
		$this->mapperGenerator = $generator;
	}

	public function getFacadeGenerator(): IGenerator
	{
		return $this->facadeGenerator;
	}

	public function setFacadeGenerator(IGenerator $generator): void
	{
		$this->facadeGenerator = $generator;
	}

	public function getModelGenerator(): IGenerator
	{
		return $this->modelGenerator;
	}

	public function setModelGenerator(IGenerator $generator): void
	{
		$this->modelGenerator = $generator;
	}

	/**
	 * Generate ORM
	 */
	public function generate(): void
	{
		$database = $this->analyser->analyse();

		if ($this->config->getBool('generator.generate.entities')) {
			$this->entityGenerator->generate($database);
		}

		if ($this->config->getBool('generator.generate.repositories')) {
			$this->repositoryGenerator->generate($database);
		}

		if ($this->config->getBool('generator.generate.mappers')) {
			$this->mapperGenerator->generate($database);
		}

		if ($this->config->getBool('generator.generate.facades')) {
			$this->facadeGenerator->generate($database);
		}

		if ($this->config->getBool('generator.generate.model')) {
			$this->modelGenerator->generate($database);
		}
	}

}
