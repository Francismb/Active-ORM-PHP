<?php

namespace ActiveORM;

/**
 * Class Query.
 * @package ActiveORM
 */
class Query
{
    /**
     * @var \ActiveORM\Definition\Table
     */
    private $table;

    /**
     * Query constructor.
     * @param \ActiveORM\Definition\Table $table
     */
    public function __construct($table)
    {
        $this->table = $table;
    }

    /**
     * Either updates or inserts the model depending on if the ID is present.
     */
    public function save()
    {
        $row = $this->compileTable($this->table);

        if ($this->table->getIdentifier()->getValue() != null)
        {
            ActiveRecordDB::getDatabase()->update($this->table->getName(), $row, self::createIdentifier($this->table->getIdentifier()));
        }
        else
        {
            ActiveRecordDB::getDatabase()->insert($this->table->getName(), $row);
            $this->table->getIdentifier()->setValue(ActiveRecordDB::getDatabase()->id());
        }
    }

    /**
     * Deletes a record from the database if it exists
     */
    public function delete() {
        if ($this->table->getIdentifier()->getValue() != null)
        {
            ActiveRecordDB::getDatabase()->delete($this->table->getName(), self::createIdentifier($this->table->getIdentifier()));
        }
    }

    /**
     * Finds a record and creates a model instance based off an ID.
     * @param int $id The id of the record.
     * @return ActiveRecord
     */
    public static function findByID($id)
    {
        $table = static::define();
        return self::findOne([$table->getIdentifier()->getName() => $id]);
    }

    /**
     * Finds a record and creates a model based off the criteria.
     * @param array $criteria The 'where' of the query.
     * @return ActiveRecord
     */
    public static function findOne($criteria)
    {
        $table = static::define();

        $row = ActiveRecordDB::getDatabase()->get($table->getName(), '*', $criteria);

        if ($row)
        {
            $model = new static();

            foreach ($row as $column => $value)
            {
                $model->__set($column, $value);
            }

            return $model;
        }

        return null;
    }

    /**
     * Finds multiple records and creates multiple models based off the criteria.
     * @param array $criteria The 'where' of the query.
     * @return array of ActiveORMS.
     */
    public static function findAll($criteria = [])
    {
        $table = static::define();

        $rows = ActiveRecordDB::getDatabase()->select($table->getName(), '*', $criteria);

        if ($rows)
        {
            $models = [];
            foreach ($rows as $row)
            {
                $model = new static();
                foreach ($row as $column => $value)
                {
                    $model->__set($column, $value);
                }
                $models[] = $model;
            }
            return $models;
        }

        return $rows;
    }

    /**
     * Checks to see if the record exists.
     * @param array $criteria The 'where' of the query.
     * @return bool True if it exists else false.
     */
    public static function exists($criteria)
    {
        $table = static::define();
        return ActiveRecordDB::getDatabase()->has($table->getName(), $criteria);
    }

    /**
     * Gets the amount of records that match the criteria.
     * @param array $criteria The 'where' of the query.
     * @return int The amount of records.
     */
    public static function count($criteria = [])
    {
        $table = static::define();
        return ActiveRecordDB::getDatabase()->count($table->getName(), $criteria);
    }

    /**
     * Compiles a Table object into an associative array
     * @param \ActiveORM\Definition\Table $table
     * @return array the compiled table
     */
    private function compileTable($table)
    {
        $data = [];

        foreach($table->getColumns() as $key => $column)
        {
            $data[$key] = $column->getValue();
        }

        return $data;
    }

    /**
     * @param \ActiveORM\Definition\PrimaryKeyColumn $identifier.
     * @return array.
     */
    private function createIdentifier($identifier)
    {
        return [$identifier->getName() => $identifier->getValue()];
    }
}