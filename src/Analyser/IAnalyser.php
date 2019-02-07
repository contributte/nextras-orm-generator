<?php

namespace Contributte\Nextras\Orm\Generator\Analyser;

use Contributte\Nextras\Orm\Generator\Entity\Database;

interface IAnalyser
{

    /**
     * @return Database
     */
    function analyse();

}
