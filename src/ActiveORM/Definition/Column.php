<?php

namespace ActiveORM\Definition;

/**
 * Interface Column.
 * @package ActiveORM\Definition
 */
abstract class Column
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $columnName;

    /**
     * @var string
     */
    protected $type;

    /**
     * @var mixed
     */
    protected $value;

    /**
     * @var int
     */
    protected $originalValue;

    /**
     * Column constructor.
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
     * Returns the name we use to access the column.
     * @return string The name used to access the column.
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
     * Checks to see if the column has been modified.
     * @return bool
     */
    public function updated()
    {
        return $this->value != $this->originalValue;
    }

    /**
     * Refreshes the column setting the original value
     * to the current value.
     */
    public function refresh()
    {
        $this->originalValue = $this->value;
    }

    /**
     * Sets the value of the column.
     * @param mixed $value The value of the column.
     * @param bool $originalValue Determines if this is the original value
     * @return
     */
    public abstract function setValue($value, $originalValue = false);
}