<?php

namespace Minetro\Normgen;

use Minetro\Normgen\Analyser\IAnalyser;
use Minetro\Normgen\Config\Config;
use Minetro\Normgen\Exception\InvalidStrategyException;
use Minetro\Normgen\Generator\Entity\EntityGenerator;
use Minetro\Normgen\Generator\Facade\FacadeGenerator;
use Minetro\Normgen\Generator\Mapper\MapperGenerator;
use Minetro\Normgen\Generator\Repository\RepositoryGenerator;
use Minetro\Normgen\Resolver\Impl\SimpleSeparateResolver;
use Minetro\Normgen\Resolver\Impl\SimpleTogetherResolver;

final class SimpleFactory
{

    /** @var Config */
    private $config;

    /** @var IAnalyser */
    private $analyser;

    /**
     * @param Config $config
     * @param IAnalyser $analyser
     */
    public function __construct(Config $config, IAnalyser $analyser)
    {
        $this->config = $config;
        $this->analyser = $analyser;
    }

    /**
     * @return Normgen
     */
    public function create()
    {
        $normgen = new Normgen($this->config, $this->analyser);

        if ($this->config->get('generator.generate.strategy') === Config::STRATEGY_TOGETHER) {
            $resolver = new SimpleTogetherResolver($this->config);
        } else if ($this->config->get('generator.generate.strategy') === Config::STRATEGY_SEPARATE) {
            $resolver = new SimpleSeparateResolver($this->config);
        } else {
            throw new InvalidStrategyException();
        }

        $normgen->setEntityGenerator(new EntityGenerator($this->config, $resolver));
        $normgen->setRepositoryGenerator(new RepositoryGenerator($this->config, $resolver));
        $normgen->setMapperGenerator(new MapperGenerator($this->config, $resolver));
        $normgen->setFacadeGenerator(new FacadeGenerator($this->config, $resolver));

        return $normgen;
    }

}
