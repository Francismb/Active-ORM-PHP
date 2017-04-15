<?php

namespace ActiveORM\Definition;

use ActiveORM\Exceptions\IncorrectDataTypeException;

/**
 * Class GenericColumn.
 * @package ActiveORM\Definition
 */
class GenericColumn implements Column
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $columnName;

    /**
     * @var string
     */
    private $type;

    /**
     * @var mixed
     */
    private $value;

    /**
     * @var int
     */
    private $originalValue;

    /**
     * GenericColumn constructor.
     * @param string $name The string to access this column.
     * @param string $columnName The name of the column.
     * @param string $type The data type of the column.
     */
    public function __construct($name, $columnName, $type)
    {
        $this->name = $name;
        $this->type = $type;
        $this->columnName = $columnName;
    }

    /**
     * Returns the name of the column.
     * @return string The name of the column.
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Returns the name of the column in the table.
     * @return string The name of the column
     */
    public function getColumnName()
    {
        return $this->columnName;
    }

    /**
     * Returns the value of the column.
     * @return mixed The value of the column.
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Sets the value of the column.
     * @param mixed $value The value of the column.
     * @param bool $originalValue Determines if this is the original value
     * @throws \ActiveORM\Exceptions\IncorrectDataTypeException
     */
    public function setValue($value, $originalValue = false)
    {
        $type = gettype($value);
        if ($type == $this->type)
        {
            $this->value = $value;

            if ($originalValue)
            {
                $this->originalValue = $value;
            }
        }
        else
        {
            throw new IncorrectDataTypeException($this->getName(), $type);
        }
    }

    /**
     * Checks to see if the column has been modified.
     * @return bool
     */
    public function hasBeenUpdated()
    {
        return $this->value != $this->originalValue;
    }
}