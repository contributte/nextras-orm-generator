<?php declare(strict_types = 1);

namespace Contributte\Nextras\Orm\Generator;

use Contributte\Nextras\Orm\Generator\Analyser\IAnalyser;
use Contributte\Nextras\Orm\Generator\Config\Config;
use Contributte\Nextras\Orm\Generator\Exception\InvalidStrategyException;
use Contributte\Nextras\Orm\Generator\Generator\Entity\EntityGenerator;
use Contributte\Nextras\Orm\Generator\Generator\Facade\FacadeGenerator;
use Contributte\Nextras\Orm\Generator\Generator\Mapper\MapperGenerator;
use Contributte\Nextras\Orm\Generator\Generator\Model\ModelGenerator;
use Contributte\Nextras\Orm\Generator\Generator\Repository\RepositoryGenerator;
use Contributte\Nextras\Orm\Generator\Resolver\Impl\SimpleSeparateResolver;
use Contributte\Nextras\Orm\Generator\Resolver\Impl\SimpleTogetherResolver;

final class SimpleFactory
{

	/** @var Config */
	private $config;

	/** @var IAnalyser */
	private $analyser;

	public function __construct(Config $config, IAnalyser $analyser)
	{
		$this->config = $config;
		$this->analyser = $analyser;
	}

	public function create(): Generator
	{
		$normgen = new Generator($this->config, $this->analyser);

		if ($this->config->get('generator.generate.strategy') === Config::STRATEGY_TOGETHER) {
			$resolver = new SimpleTogetherResolver($this->config);
		} elseif ($this->config->get('generator.generate.strategy') === Config::STRATEGY_SEPARATE) {
			$resolver = new SimpleSeparateResolver($this->config);
		} else {
			throw new InvalidStrategyException();
		}

		$normgen->setEntityGenerator(new EntityGenerator($this->config, $resolver));
		$normgen->setRepositoryGenerator(new RepositoryGenerator($this->config, $resolver, $resolver));
		$normgen->setMapperGenerator(new MapperGenerator($this->config, $resolver));
		$normgen->setFacadeGenerator(new FacadeGenerator($this->config, $resolver));
		$normgen->setModelGenerator(new ModelGenerator($this->config, $resolver, $resolver, $resolver));

		return $normgen;
	}

}
