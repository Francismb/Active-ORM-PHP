<?php
/**
 * Created by PhpStorm.
 * User: francis
 * Date: 2/28/17
 * Time: 1:48 PM
 */
namespace ActiveORM;

class ActiveRecord extends Query
{
    /**
     * @var \ActiveORM\Definition\Table The definition of the table and columns.
     */
    private $table;

    /**
     * Constructs a new ActiveRecord.
     * Calls the static define function.
     * @param array $columns The values of this record.
     */
    public function __construct($columns = [])
    {
        $this->table = static::define();
        parent::__construct($this->table);

        if (count($columns) > 0)
        {
            foreach($columns as $name => $value)
            {
                $this->__set($name, $value);
            }
        }
    }

    /**
     * Overriding the set magic method to save mappings
     * @param string $name the name of the field
     * @param mixed $value the value of the field
     * @throws \ActiveORM\Exceptions\ColumnNotDefinedException
     */
    public function __set($name, $value)
    {
        if ($this->table->hasColumn($name))
        {
            $this->table->getColumn($name)->setValue($value);
        }
        else
        {
            throw new \ActiveORM\Exceptions\ColumnNotDefinedException($name);
        }
    }

    /**
     * Overriding the get magic method to give proper values
     * @param string $name the name of the field
     * @throws \ActiveORM\Exceptions\ColumnNotDefinedException
     */
    public function __get($name)
    {
        if ($this->table->hasColumn($name))
        {
            return $this->table->getColumn($name)->getValue();
        }
        else
        {
            throw new \ActiveORM\Exceptions\ColumnNotDefinedException($name);
        }
    }
}