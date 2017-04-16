<?php

namespace ActiveORM;

use ActiveORM\Exceptions\ColumnNotDefinedException;
use ActiveORM\Validation\Validatable;

/**
 * Class ActiveRecord.
 * @package ActiveORM
 */
class ActiveRecord extends Queryable
{
    /**
     * Use the validatable trait.
     */
    use Validatable;

    /**
     * @var ActiveRecordDefinition The definition of the table and columns.
     */
    public $definition;

    /**
     * Constructs a new ActiveRecord.
     * Calls the static define function.
     * @param array $columns The key and values of this record.
     */
    public function __construct($columns = [])
    {
        $this->definition = static::define();
        parent::__construct($this->definition);

        foreach ($this->definition->getRelationships() as $relationship)
        {
            $relationship->setOwner($this);
        }

        foreach($columns as $name => $value)
        {
            $this->__set($name, $value);
        }

        if (method_exists($this, "validate"))
        {
            $this->validate();
        }
    }

    /**
     * Overriding the set magic method to save mappings.
     * @param string $name the name of the field.
     * @param mixed $value the value of the field.
     * @throws Exceptions\ColumnNotDefinedException.
     */
    public function __set($name, $value)
    {
        if ($this->definition->getTable()->hasColumn($name))
        {
            $this->definition->getTable()->getColumn($name)->setValue($value);
        }
        else
        {
            foreach ($this->definition->getRelationships() as $relationship)
            {
                if ($relationship->getName() == $name)
                {
                    $relationship->setValue($value);
                    return;
                }
            }
            throw new ColumnNotDefinedException($this->definition->getTable()->getName(), $name);
        }
    }

    /**
     * Overriding the get magic method to give proper values.
     * @param string $name the name of the field.
     * @return mixed The value of the column.
     * @throws Exceptions\ColumnNotDefinedException.
     */
    public function __get($name)
    {
        if ($this->definition->getTable()->hasColumn($name))
        {
            return $this->definition->getTable()->getColumn($name)->getValue();
        }
        else
        {
            foreach ($this->definition->getRelationships() as $relationship)
            {
                if ($relationship->getName() == $name)
                {
                    return $relationship->getValue();
                }
            }
            throw new ColumnNotDefinedException($this->definition->getTable()->getName(), $name);
        }
    }

    /**
     * Overriding the call magic method to allow for foreign key queries.
     * @param string $method The method name.
     * @param array $args The method arguments.
     * @return mixed
     * @throws Exceptions\ColumnNotDefinedException
     */
    // TODO implement queriable relationships
    public function __call($method, $args)
    {
        if ($this->definition->getTable()->hasColumn($method))
        {
            $column = $this->definition->getTable()->getColumn($method);
        }
        else
        {
            throw new ColumnNotDefinedException($this->definition->getTable()->getName(), $method);
        }
    }
}