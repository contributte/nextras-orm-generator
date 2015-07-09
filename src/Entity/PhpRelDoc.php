<?php

namespace Minetro\Normgen\Entity;

use Minetro\Normgen\Utils\DocBuilder;

class PhpRelDoc
{

    /** Order directions */
    const ASC = 1;
    const DESC = 2;

    /** @var string */
    private $type;

    /** @var string */
    private $entity;

    /** @var string */
    private $variable;

    /** @var bool */
    private $primary;

    /** @var string */
    private $orderProperty;

    /** @var int */
    private $orderDirection;

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getEntity()
    {
        return $this->entity;
    }

    /**
     * @param string $entity
     */
    public function setEntity($entity)
    {
        $this->entity = $entity;
    }

    /**
     * @return string
     */
    public function getVariable()
    {
        return $this->variable;
    }

    /**
     * @param string $variable
     */
    public function setVariable($variable)
    {
        $this->variable = $variable;
    }

    /**
     * @return boolean
     */
    public function isPrimary()
    {
        return $this->primary;
    }

    /**
     * @param boolean $primary
     */
    public function setPrimary($primary)
    {
        $this->primary = (bool)$primary;
    }

    /**
     * @return string
     */
    public function getOrderProperty()
    {
        return $this->orderProperty;
    }

    /**
     * @param string $orderProperty
     */
    public function setOrderProperty($orderProperty)
    {
        $this->orderProperty = $orderProperty;
    }

    /**
     * @return int
     */
    public function getOrderDirection()
    {
        return $this->orderDirection;
    }

    /**
     * @param int $direction
     */
    public function setOrderDirection($direction)
    {
        if (in_array($direction, [self::ASC, self::DESC])) {
            throw new \InvalidArgumentException('Unknown order direction ' . $direction);
        }

        $this->orderDirection = $direction;
    }

    /**
     * @return string
     */
    function __toString()
    {
        $b = new DocBuilder();

        // Type (1:m, m:1, m:n, etc..)
        $b->append($this->type);

        // Entity and variable (Entity::$variable)
        if ($this->variable) {
            $b->str(ucfirst($this->entity));
            $b->str('::');
            $b->append('$' . $this->variable);
        } else {
            $b->append(ucfirst($this->entity));
        }

        // Primary
        if ($this->primary) {
            $b->append('primary');
        }

        // Order (order:*property*)
        if ($this->orderProperty) {
            $b->append('order:' . $this->orderProperty);
        }

        // Ordering (DESC/ASC)
        if ($this->orderDirection) {
            $b->append($this->orderDirection === self::ASC ? 'ASC' : 'DESC');
        }

        return (string)$b;
    }

}
