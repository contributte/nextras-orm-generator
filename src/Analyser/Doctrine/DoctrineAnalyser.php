<?php

namespace Minetro\Normgen\Analyser\Database;

use Minetro\Normgen\Analyser\IAnalyser;
use Minetro\Normgen\Entity\Database;
use Minetro\Normgen\Exception\NotImplementedException;

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
