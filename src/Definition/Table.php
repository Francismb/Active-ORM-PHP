<?php

/**
 * Created by PhpStorm.
 * User: francis
 * Date: 3/8/17
 * Time: 12:44 PM
 */
namespace Definition;

/**
 * Class Table
 * Represents a table in a database.
 * @package Definition
 */
class Table
{
    private $name;
    private $identifier;
    private $columns;

    /**
     * Table constructor.
     * @param string $name The name of the table.
     * @param array $columns An associative array of columns.
     */
    public function __construct($name, $columns)
    {
        $this->name = $name;

        foreach($columns as $column)
        {
            if ($column->isPrimaryKey())
            {
                $this->identifier = $column;
            }
            $this->columns[$column->getName()] = $column;
        }
    }

    /**
     * @return string The name of the table.
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return array An array of columns.
     */
    public function getColumns()
    {
        return $this->columns;
    }

    /**
     * @param string $name The name of the column.
     * @return Column.
     * @throws \Exceptions\ColumnNotDefinedException
     */
    public function getColumn($name)
    {
        if (!$this->hasColumn($name)) {
            throw new \Exceptions\ColumnNotDefinedException($name);
        }
        return $this->columns[$name];
    }

    /**
     * Checks to see if this table contains a certain column.
     * @param string $name The name of the column.
     * @return bool True if the table contains the column else false.
     */
    public function hasColumn($name)
    {
        return isset($this->columns[$name]);
    }
}