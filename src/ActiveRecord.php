<?php
/**
 * Created by PhpStorm.
 * User: francis
 * Date: 2/28/17
 * Time: 1:48 PM
 */

class ActiveRecord
{
    /**
     * Import the query traits for lookup's and save/delete.
     */
    use Query;

    /**
     * The definition of the table and columns.
     */
    private $table;

    /**
     * Constructs a new ActiveRecord.
     * Calls the static define function.
     */
    public function __construct()
    {
        $this->table = static::define();
    }

    /**
     * Overriding the set magic method to save mappings
     * @param $name the name of the field
     * @param $value the value of the field
     * @throws \exceptions\ColumnNotDefinedException
     */
    public function __set($name, $value)
    {
        if ($this->table->hasColumn($name))
        {
            $this->table->getColumn($name)->setValue($name);
        }
        else
        {
            throw new \Exceptions\ColumnNotDefinedException($name);
        }
    }

    /**
     * Overriding the get magic method to give proper values
     * @param $name the name of the field
     * @throws \exceptions\ColumnNotDefinedException
     */
    public function __get($name)
    {
        if ($this->table->hasColumn($name))
        {
            $this->table->getColumn($name)->getValue();
        }
        else
        {
            throw new \Exceptions\ColumnNotDefinedException($name);
        }
    }
}