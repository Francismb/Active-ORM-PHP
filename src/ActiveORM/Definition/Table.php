<?php

namespace ActiveORM\Definition;

use ActiveORM\Exceptions\ColumnNotDefinedException;

/**
 * Class Table.
 * Represents a table in a database.
 * @package Definition
 */
class Table
{
    /**
     * @var string The name of the table.
     */
    private $name;

    /**
     * @var PrimaryKeyColumn The primary key column of this table.
     */
    private $identifier;

    /**
     * @var Column[] An array of the columns that this table contains.
     */
    private $columns;

    /**
     * @var int[] An array of column name indexes to be used with the columns array.
     */
    private $columnIndexes;

    /**
     * @var int[] An array of access name indexes to be used with the columns array.
     */
    private $accessIndexes;

    /**
     * Table constructor.
     * @param string $name The name of the table.
     * @param array $columns An associative array of columns.
     */
    public function __construct($name, $columns)
    {
        $this->name = $name;

        for ($index = 0; $index < count($columns); $index++)
        {
            $column = $columns[$index];

            $this->accessIndexes[$column->getName()] = $index;
            $this->columnIndexes[$column->getColumnName()] = $index;

            if ($column instanceof PrimaryKeyColumn)
            {
                $this->identifier = $column;
            }

            $this->columns[] = $column;
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
        $index = $this->getColumnIndex($name);
        if ($index == -1)
        {
            throw new ColumnNotDefinedException($this->name, $name);
        }
        return $this->columns[$index];
    }

    /**
     * Checks to see if this table contains a certain column.
     * @param string $name The name of the column.
     * @return bool True if the table contains the column else false.
     */
    public function hasColumn($name)
    {
        return $this->getColumnIndex($name) != -1;
    }

    /**
     * Gets the index of a column in the column array
     * @param string $name The name of the column
     * @return int The index of the column
     */
    private function getColumnIndex($name)
    {
        if (isset($this->accessIndexes[$name]))
        {
            return $this->accessIndexes[$name];
        }
        if (isset($this->columnIndexes[$name]))
        {
            return $this->columnIndexes[$name];
        }
        return -1;
    }

    /**
     * Returns true if any table values have been updated since load.
     * @return bool
     */
    public function updated()
    {
        foreach ($this->columns as $column)
        {
            if ($column->updated())
            {
                return true;
            }
        }
        return false;
    }

    /**
     * Refreshes the table setting the original values to the current values.
     */
    public function refresh()
    {
        foreach ($this->columns as $column)
        {
            $column->refresh();
        }
    }

}