<?php

/**
 * Created by PhpStorm.
 * User: francis
 * Date: 3/8/17
 * Time: 12:44 PM
 */
namespace ActiveORM\Definition;

/**
 * Class Table
 * Represents a table in a database.
 * @package Definition
 */
class Table
{
    /**
     * @var string The name of the table
     */
    private $name;

    /**
     * @var PrimaryKeyColumn The primary key column of this table
     */
    private $identifier;

    /**
     * @var array An array of the columns that this table contains
     */
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
            if ($column instanceof PrimaryKeyColumn)
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
     * @return PrimaryKeyColumn The identifier of the table.
     */
    public function getIdentifier()
    {
        return $this->identifier;
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
     * @throws \ActiveORM\Exceptions\ColumnNotDefinedException
     */
    public function getColumn($name)
    {
        if (!$this->hasColumn($name)) {
            throw new \ActiveORM\Exceptions\ColumnNotDefinedException($name);
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