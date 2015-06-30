<?php

use Minetro\Normgen\Analyser\DatabaseAnalyser;
use Minetro\Normgen\Config;
use Minetro\Normgen\Normgen;
use Minetro\Resolver\SimpleResolver;
use Tracy\Debugger;

require_once __DIR__ . '/../vendor/autoload.php';

Debugger::enable(Debugger::DEVELOPMENT, __DIR__);

$config = new Config([
    'output' => __DIR__ . '/model',
]);

$generator = new Normgen(
    $config,
    new DatabaseAnalyser('mysql:host=localhost;dbname=normgen', 'root'),
    new SimpleResolver($config)
);

$generator->generate();
