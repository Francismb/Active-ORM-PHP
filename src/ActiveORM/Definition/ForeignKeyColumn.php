<?php

namespace ActiveORM\Definition;

/**
 * Class ForeignKeyColumn.
 * @package ActiveORM\Definition
 */
class ForeignKeyColumn implements Column
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var int
     */
    private $value = null;

    /**
     * ForeignKeyColumn constructor.
     * @param string $name The name of the column
     */
    public function __construct($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getType()
    {
        return 'int';
    }

    public function getValue()
    {
        return $this->value;
    }

    public function setValue($value)
    {
        $this->value = $value;
    }
}