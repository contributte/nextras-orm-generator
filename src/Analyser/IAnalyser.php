<?php

namespace Minetro\Normgen\Analyser;

use Minetro\Normgen\Entity\Database;

interface IAnalyser
{

    /**
     * @return Database
     */
    function analyse();

}
