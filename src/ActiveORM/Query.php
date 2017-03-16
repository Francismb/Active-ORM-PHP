<?php
/**
 * Created by PhpStorm.
 * User: francis
 * Date: 3/8/17
 * Time: 12:32 PM
 */
namespace ActiveORM;

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
            $GLOBALS['database']->update($this->table->getName(), $row, [$this->table->getIdentifier()->getName() => $this->table->getIdentifier()->getValue()]);
        }
        else
        {
            $GLOBALS['database']->insert($this->table->getName(), $row);
            $this->table->getIdentifier()->setValue($GLOBALS['database']->id());
        }
    }

    /**
     * Deletes a record from the database if it exists
     */
    public function delete() {
        if ($this->table->getIdentifier()->getValue() != null)
        {
            $GLOBALS['database']->delete($this->table->getName(), [$this->table->getIdentifier()->getName() => $this->table->getIdentifier()->getValue()]);
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

        $row = $GLOBALS['database']->get($table->getName(), '*', $criteria);

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

        $rows = $GLOBALS['database']->select($table->getName(), '*', $criteria);

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
}