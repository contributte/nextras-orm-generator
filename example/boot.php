<?php

use Contributte\Nextras\Orm\Generator\Analyser\Database\DatabaseAnalyser;
use Contributte\Nextras\Orm\Generator\SimpleFactory;
use Tracy\Debugger;
use Contributte\Nextras\Orm\Generator\Config\Impl\SeparateConfig;
use Contributte\Nextras\Orm\Generator\Config\Impl\TogetherConfig;

require_once __DIR__ . '/../vendor/autoload.php';

Debugger::enable(Debugger::DEVELOPMENT, __DIR__);

$factory = new SimpleFactory(
    new SeparateConfig(['output' => __DIR__ . '/model/separate-' . time()]),
    new DatabaseAnalyser('mysql:host=127.0.0.1;dbname=nextras_orm_generator', 'root')
);

$factory->create()->generate();

$factory = new SimpleFactory(
    new TogetherConfig(['output' => __DIR__ . '/model/together-' . time()]),
    new DatabaseAnalyser('mysql:host=127.0.0.1;dbname=nextras_orm_generator', 'root')
);

$factory->create()->generate();