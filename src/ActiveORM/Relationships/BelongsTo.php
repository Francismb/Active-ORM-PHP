<?php
/**
 * Created by PhpStorm.
 * User: francis
 * Date: 3/19/17
 * Time: 9:44 AM
 */

namespace ActiveORM\Relationships;

use ActiveORM\ActiveRecord;

class BelongsTo extends Relationship
{
    /**
     * @var ActiveRecord The value of this relationship
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
            $class::define()->getTable()->getIdentifier()->getColumnName() => $this->owner->definition->getTable()->getColumn($this->column)->getValue()
        ]);

        return $this->value;
    }

    /**
     * Sets the value of the relationship
     * @param mixed $value
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
            $this->value->save();

            $this->owner->definition->getTable()->getColumn($this->column)->setValue(
                $this->value->definition->getTable()->getIdentifier()->getValue()
            );
            $this->owner->save();
        }
    }
}