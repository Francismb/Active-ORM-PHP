<?php
/**
 * Created by PhpStorm.
 * User: francis
 * Date: 3/8/17
 * Time: 12:40 PM
 */
namespace Definition;

/**
 * Class Column
 * Represents a column in a databases table.
 * @package Definition
 */
class Column
{

    private $name;
    private $type;
    private $value;

    private $primaryKey = false;
    private $foreignKey = false;

    /**
     * Creates a new Column object to represent a generic database table column.
     * @param string $name The name of the column.
     * @param string $type The type of the column.
     * @return Column
     */
    public static function generic($name, $type)
    {
        $column = new self();
        $column->name = $name;
        $column->type = $type;
        return $column;
    }

    /**
     * Creates a new Column object to represent a primary key column.
     * @param string $name The name of the column, generally 'id'.
     * @return Column
     */
    public static function primary($name)
    {
        $column = new self();
        $column->name = $name;
        $column->type = "int";
        $column->primaryKey = true;
        return $column;
    }

    /**
     * Creates a new Column object to represent a foreign key column.
     * @param string $name The name of the column, generally 'xxxx_id'.
     * @return Column
     */
    public static function foreign($name)
    {
        $column = new self();
        $column->name = $name;
        $column->type = "int";
        $column->foreignKey = true;
        return $column;
    }

    /**
     * @return string The name of the column.
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string The type of the column.
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return mixed The value of the column.
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param mixed $value The value of the column.
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * @return bool True if the column represents a primary key else false.
     */
    public function isPrimaryKey()
    {
        return $this->primaryKey;
    }

    /**
     * @return bool True of the column represents a foreign key else false.
     */
    public function isForeignKey()
    {
        return $this->foreignKey;
    }

}