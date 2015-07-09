<?php

use Minetro\Normgen\Analyser\DatabaseAnalyser;
use Minetro\Normgen\Config;
use Minetro\Normgen\Normgen;
use Tracy\Debugger;

require_once __DIR__ . '/../vendor/autoload.php';

Debugger::enable(Debugger::DEVELOPMENT, __DIR__);

$generator = new Normgen(
    new Config(['output' => __DIR__ . '/model']),
    new DatabaseAnalyser('mysql:host=localhost;dbname=burza', 'root')
);

$generator->generate();
