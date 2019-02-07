<?php

namespace Contributte\Nextras\Orm\Generator\Generator;

use Contributte\Nextras\Orm\Generator\Config\Config;
use Contributte\Nextras\Orm\Generator\Entity\Database;
use Nette\Utils\FileSystem;

abstract class AbstractGenerator implements IGenerator
{

    /** @var Config */
    protected $config;

    /**
     * @param Config $config
     */
    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    /**
     * Generate file
     *
     * @param string $filename
     * @param string $code
     */
    protected function generateFile($filename, $code)
    {
        FileSystem::write($this->config->get('output') . DIRECTORY_SEPARATOR . $filename, "<?php\n\n$code");
    }

    /**
     * @param Database $database
     * @return void
     */
    abstract function generate(Database $database);

}
