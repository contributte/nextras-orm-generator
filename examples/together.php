<?php declare(strict_types = 1);

use Contributte\Nextras\Orm\Generator\Analyser\Database\DatabaseAnalyser;
use Contributte\Nextras\Orm\Generator\Config\Impl\TogetherConfig;
use Contributte\Nextras\Orm\Generator\SimpleFactory;
use Nette\Utils\FileSystem;
use Tracy\Debugger;

require_once __DIR__ . '/../vendor/autoload.php';

FileSystem::createDir(__DIR__ . '/log');
Debugger::enable(Debugger::DEBUG, __DIR__ . '/log');

$factory = new SimpleFactory(
	new TogetherConfig(['output' => __DIR__ . '/model/together']),
	new DatabaseAnalyser('sqlite:db.sqlite')
);

$factory->create()->generate();
