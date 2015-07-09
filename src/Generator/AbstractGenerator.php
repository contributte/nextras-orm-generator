<?php

namespace Minetro\Normgen;

use Minetro\Normgen\Entity\Database;
use Nette\Utils\FileSystem;

abstract class AbstractGenerator
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
     * @param string $folder
     * @param string $filename
     * @param string $code
     */
    protected function generateFile($folder, $filename, $code)
    {
        FileSystem::write($this->config->get('output') . DIRECTORY_SEPARATOR . $folder . DIRECTORY_SEPARATOR . $filename, "<?php\n\n$code");
    }

    /**
     * @param Database $database
     * @return void
     */
    abstract function generate(Database $database);

}
