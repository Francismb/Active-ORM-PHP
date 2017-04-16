<?php

namespace ActiveORM\Definition;

/**
 * Interface Column.
 * @package ActiveORM\Definition
 */
abstract class Column
{
    /**
     * @var string The name of this column used to access it.
     */
    protected $name;

    /**
     * @var string The name of the column in the database.
     */
    protected $columnName;

    /**
     * @var string The datatype of this column.
     */
    protected $type;

    /**
     * @var mixed The value of this column.
     */
    protected $value;

    /**
     * @var mixed The original value of this column. Used to determine if it has been changed.
     */
    protected $originalValue;

    /**
     * Column constructor.
     * @param string $name The name of this column used to access it.
     * @param string $columnName The name of the column in the database.
     * @param string $type The datatype of the column.
     */
    public function __construct($name, $columnName, $type)
    {
        $this->name = $name;
        $this->type = $type;
        $this->columnName = $columnName;
    }

    /**
     * Returns the name of this column used to access it.
     * @return string The name of this column used to access it.
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Returns the name of the column in the database.
     * @return string The name of the column in the database.
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