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
    private $rawValue = null;

    /**
     * @var \ActiveORM\ActiveRecord
     */
    private $value = null;

    /**
     * Has one relationship.
     */
    const HAS_ONE = 1;

    /**
     * Has many relationship.
     */
    const HAS_MANY = 2;

    /**
     * Belongs to relationship.
     */
    const BELONGS_TO = 3;

    /**
     * ForeignKeyColumn constructor.
     * @param string $name The name of the column
     * @param $relationship
     */
    public function __construct($name, $relationship)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getType()
    {
        return 'integer';
    }

    public function getValue()
    {
        return $this->value;
    }

    public function setValue($value)
    {
        $type = gettype($value);
        if ($type == 'integer')
        {
            $this->rawValue = $value;
        }
        else if ($type == 'object')
        {
            $this->value = $value;
        }
        else
        {
            throw new \ActiveORM\Exceptions\IncorrectDataTypeException($this->getName(), $type);
        }
    }
}