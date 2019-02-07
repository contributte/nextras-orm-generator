<?php

namespace Contributte\Nextras\Orm\Generator\Analyser\Database;

use Contributte\Nextras\Orm\Generator\Analyser\IAnalyser;
use Contributte\Nextras\Orm\Generator\Entity\Database;
use Contributte\Nextras\Orm\Generator\Exception\NotImplementedException;

class DoctrineAnalyser implements IAnalyser
{

    /** @var string */
    private $folder;

    /**
     * @param string $folder
     */
    function __construct($folder)
    {
        $this->folder = $folder;
    }

    /**
     * @return Database
     */
    public function analyse()
    {
        throw new NotImplementedException();
    }

}
