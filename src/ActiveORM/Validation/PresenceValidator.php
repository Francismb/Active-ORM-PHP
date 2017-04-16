<?php
/**
 * Created by PhpStorm.
 * User: francis
 * Date: 4/16/17
 * Time: 2:30 PM
 */

namespace ActiveORM\Validation;


use ActiveORM\ActiveRecord;

class PresenceValidator extends Validator
{

    /**
     * PresenceValidator constructor.
     * @param string $name The name of the variable which we are doing validation on.
     * @param string $message The error message if this validation fails.
     * @param ActiveRecord $activeRecord The active record that we are doing validation on.
     */
    public function __construct($name, $message, $activeRecord)
    {
        parent::__construct($name, $message, $activeRecord);
    }

    /**
     * Checks to see if this validator is valid.
     */
    public function valid()
    {
        return $this->activeRecord->definition->getTable()->getColumn($this->name)->getValue() != null;
    }
}