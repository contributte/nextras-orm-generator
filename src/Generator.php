<?php declare(strict_types = 1);

namespace Contributte\Nextras\Orm\Generator;

use Contributte\Nextras\Orm\Generator\Analyser\IAnalyser;
use Contributte\Nextras\Orm\Generator\Config\Config;
use Contributte\Nextras\Orm\Generator\Generator\IGenerator;

class Generator
{

	/** @var Config */
	private $config;

	/** @var IAnalyser */
	private $analyser;

	/** @var IGenerator */
	private $entityGenerator;

	/** @var IGenerator */
	private $repositoryGenerator;

	/** @var IGenerator */
	private $mapperGenerator;

	/** @var IGenerator */
	private $facadeGenerator;

	/** @var IGenerator */
	private $modelGenerator;

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

		if ($this->config->get('generator.generate.entities')) {
			$this->entityGenerator->generate($database);
		}

		if ($this->config->get('generator.generate.repositories')) {
			$this->repositoryGenerator->generate($database);
		}

		if ($this->config->get('generator.generate.mappers')) {
			$this->mapperGenerator->generate($database);
		}

		if ($this->config->get('generator.generate.facades')) {
			$this->facadeGenerator->generate($database);
		}

		if ($this->config->get('generator.generate.model')) {
			$this->modelGenerator->generate($database);
		}
	}

}
