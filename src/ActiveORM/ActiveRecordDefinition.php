<?php
/**
 * Created by PhpStorm.
 * User: francis
 * Date: 4/14/17
 * Time: 11:20 AM
 */

namespace ActiveORM;


use ActiveORM\Definition\Table;
use ActiveORM\Relationships\HasMany;
use ActiveORM\Relationships\HasOne;
use ActiveORM\Relationships\Relationship;

class ActiveRecordDefinition
{
    /**
     * @var Table
     */
    private $table;

    /**
     * @var Relationship[]
     */
    private $relationships;

    /**
     * ActiveRecordDefinition constructor.
     * @param Table $table
     * @param Relationship[] $relationships
     * @throws \Exception
     */
    public function __construct($table, $relationships)
    {
        if (count($table->getColumns()) == 0) {
            throw new \Exception('ActiveRecordDefinition requires at least one column to be defined in the table');
        }

        $this->table = $table;
        $this->relationships = $relationships;
    }

    public function getTable()
    {
        return $this->table;
    }

    public function getRelationships()
    {
        return $this->relationships;
    }
}