<?php

namespace ActiveORM\Definition;

use ActiveORM\Exceptions\IncorrectDataTypeException;

/**
 * Class PrimaryKeyColumn.
 * @package ActiveORM\Definition
 */
class PrimaryKeyColumn implements Column
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
     * @var int
     */
    private $value = null;

    /**
     * @var int
     */
    private $originalValue = null;

    /**
     * PrimaryKeyColumn constructor.
     * @param string $name The string to access the column.
     * @param string $columnName The name of the column.
     */
    public function __construct($name = 'id', $columnName = 'id')
    {
        $this->name = $name;
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
     * @throws IncorrectDataTypeException
     */
    public function setValue($value, $originalValue = false)
    {
        $type = gettype($value);
        if ($type == "int" || ($type == "string" && is_numeric($value)))
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