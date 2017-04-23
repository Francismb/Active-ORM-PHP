<?php
/**
 * Created by PhpStorm.
 * User: francis
 * Date: 3/19/17
 * Time: 9:44 AM
 */

namespace ActiveORM\Relationships;

use ActiveORM\ActiveRecord;

class HasMany extends Relationship
{
    /**
     * @var ActiveRecord[] An array of active records.
     */
    private $values;

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
        if (isset($this->values)) {
            return $this->values;
        }

        $class = $this->class;
        $this->values = $class::findAll([
            $this->column => $this->owner->definition->getTable()->getIdentifier()->getValue()
        ]);

        return $this->values;
    }

    /**
     * Sets the value of the relationship
     * @param ActiveRecord[] $values
     */
    public function setValue($values)
    {
        $this->values = $values;
    }

    /**
     * Saves the relationship
     */
    public function save()
    {
        if (isset($this->values)) {
            foreach($this->values as $value) {
                $value->definition->getTable()->getColumn($this->column)->setValue(
                    $this->owner->definition->getTable()->getIdentifier()->getValue()
                );
                $value->save();
            }
        }
    }
}