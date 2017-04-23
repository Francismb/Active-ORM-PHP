<?php
/**
 * Created by PhpStorm.
 * User: francis
 * Date: 3/19/17
 * Time: 9:44 AM
 */

namespace ActiveORM\Relationships;

use ActiveORM\ActiveRecord;
use ActiveORM\Exceptions\ColumnNotDefinedException;

class HasOne extends Relationship
{
    /**
     * @var ActiveRecord An array of active records.
     */
    private $value;

    /**
     * HasMany constructor.
     * @param string $class
     * @param string $name
     * @param string $column
     */
    public function __construct($class, $name, $column)
    {
        parent::__construct($class, $name, $column);
    }

    /**
     * Returns the value of the relationship.
     * @return mixed.
     */
    public function getValue()
    {
        if (isset($this->value)) {
            return $this->value;
        }

        $class = $this->class;
        $this->value = $class::findOne([
            $this->column => $this->owner->definition->getTable()->getIdentifier()->getValue()
        ]);

        return $this->value;
    }

    /**
     * Sets the value of the relationship
     * @param ActiveRecord $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * Saves the relationship
     */
    public function save()
    {
        if (isset($this->value)) {
            $this->value->definition->getTable()->getColumn($this->column)->setValue(
                $this->owner->definition->getTable()->getIdentifier()->getValue()
            );
            $this->value->save();
        }
    }
}