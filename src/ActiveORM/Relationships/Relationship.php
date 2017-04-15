<?php
/**
 * Created by PhpStorm.
 * User: francis
 * Date: 3/19/17
 * Time: 11:12 AM
 */

namespace ActiveORM\Relationships;


use ActiveORM\ActiveRecord;

abstract class Relationship
{
    /**
     * @var ActiveRecord|String
     */
    protected $class;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $column;

    /**
     * @var ActiveRecord
     */
    protected $owner;

    /***
     * Relationship constructor.
     * @param string $class
     * @param string $name
     * @param string $column
     */
    public function __construct($class, $name, $column)
    {
        $this->class = $class;
        $this->name = $name;
        $this->column = $column;
    }

    /**
     * Returns the value of the relationship.
     * @return mixed.
     */
    public abstract function getValue();

    /**
     * Sets the value of the relationship
     * @param mixed $value
     */
    public abstract function setValue($value);

    /**
     * Saves the relationship
     */
    public abstract function save();

    /**
     * @param ActiveRecord $owner
     */
    public function setOwner($owner)
    {
        $this->owner = $owner;
    }

    public function getName()
    {
        return $this->name;
    }
}