<?php

namespace Minetro\Normgen\Generator\Entity\Decorator;

use Minetro\Normgen\Entity\Column;
use Nette\PhpGenerator\ClassType;
use Nette\PhpGenerator\PhpNamespace;

interface IDecorator
{

    /**
     * @param Column $column
     * @param ClassType $class
     * @param PhpNamespace $namespace
     * @return void
     */
    function doDecorate(Column $column, ClassType $class, PhpNamespace $namespace);
}
