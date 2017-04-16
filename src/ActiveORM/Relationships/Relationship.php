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
     * @var string The name of the class.
     */
    protected $class;

    /**
     * @var string The name of this relationship used to access it.
     */
    protected $name;

    /**
     * @var string The name of the column in the database
     */
    protected $column;

    /**
     * @var ActiveRecord The owner of this relationship
     */
    protected $owner;

    /***
     * Relationship constructor.
     * @param string $class The name of the class.
     * @param string $name  The name of this relationship used to access it.
     * @param string $column The name of the column in the database
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
     * Sets the owner of the relationship.
     * @param ActiveRecord $owner
     */
    public function setOwner($owner)
    {
        $this->owner = $owner;
    }

    /**
     * @return string The name of this relationship used to access it.
     */
    public function getName()
    {
        return $this->name;
    }
}