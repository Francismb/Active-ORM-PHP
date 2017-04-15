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

    private $hasRelationships = [];

    private $belongRelationships = [];

    /**
     * ActiveRecordDefinition constructor.
     * @param Table $table
     * @param Relationship[] $relationships
     * @throws \Exception
     */
    public function __construct($table, $relationships)
    {
        if (count($table->getColumns()) == 0)
        {
            throw new \Exception('ActiveRecordDefinition requires at least one column to be defined in the table');
        }

        $this->table = $table;
        $this->relationships = $relationships;

        foreach($this->relationships as $relationship)
        {
            if ($relationship instanceof HasMany || $relationship instanceof HasOne)
            {
                $this->hasRelationships[] = $relationship;
            }
            else
            {
                $this->belongRelationships[] = $relationship;
            }
        }
    }

    public function getTable()
    {
        return $this->table;
    }

    public function getRelationships()
    {
        return $this->relationships;
    }

    public function getHasRelationships()
    {
        return $this->hasRelationships;
    }

    public function getBelongRelationships()
    {
        return $this->belongRelationships;
    }
}