<?php declare(strict_types = 1);

use Contributte\Nextras\Orm\Generator\Analyser\Database\DatabaseAnalyser;
use Contributte\Nextras\Orm\Generator\SimpleFactory;
use Contributte\Nextras\Orm\Generator\Config\Impl\SeparateConfig;
use Nette\Utils\FileSystem;
use Tracy\Debugger;

require_once __DIR__ . '/../vendor/autoload.php';

FileSystem::createDir(__DIR__ . '/log');
Debugger::enable(Debugger::DEBUG, __DIR__ . '/log');

$factory = new SimpleFactory(
	new SeparateConfig(['output' => __DIR__ . '/model/separate']),
	new DatabaseAnalyser('sqlite:db.sqlite')
);

$factory->create()->generate();
