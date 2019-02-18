<?php declare(strict_types = 1);

namespace Contributte\Nextras\Orm\Generator\Generator;

use Contributte\Nextras\Orm\Generator\Config\Config;
use Contributte\Nextras\Orm\Generator\Entity\Database;
use Nette\Utils\FileSystem;

abstract class AbstractGenerator implements IGenerator
{

	/** @var Config */
	protected $config;

	public function __construct(Config $config)
	{
		$this->config = $config;
	}

	/**
	 * Generate file
	 */
	protected function generateFile(string $filename, string $code): void
	{
		FileSystem::write($this->config->get('output') . DIRECTORY_SEPARATOR . $filename, "<?php\n\n" . $code);
	}

	abstract public function generate(Database $database): void;

}
