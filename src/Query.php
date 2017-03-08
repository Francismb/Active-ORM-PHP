<?php

/**
 * Created by PhpStorm.
 * User: francis
 * Date: 3/8/17
 * Time: 12:32 PM
 */
trait Query
{
    /**
     * Either updates or inserts the model depending on if the ID is present.
     */
    public function save()
    {
        $table = static::define();
        $row = $this->compileTable($table);

        if (isset($this->mapping['id']))
        {
            $GLOBALS['database']->update($table->getName(), $row, ['id' => $this->mapping['id']]);
        }
        else
        {
            $GLOBALS['database']->insert($table->getName(), $row);
        }
    }

    /**
     * Deletes a record from the database if it exists
     */
    public function delete() {
        $table = static::define();

        if (isset($this->mapping['id']))
        {
            $GLOBALS['database']->delete($table->getName(), ['id' => $this->mapping['id']]);
        }
    }

    /**
     * Finds a record and creates a model instance based off an ID.
     * @param $id - id of the record.
     * @return ActiveORM
     */
    public static function findByID($id)
    {
        return self::findOne(["id" => $id]);
    }

    /**
     * Finds a record and creates a model based off the criteria.
     * @param $criteria - The 'where' of the query.
     * @return ActiveORM
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
     * @param $criteria - The 'where' of the query.
     * @return array of ActiveORMS.
     */
    public static function findAll($criteria)
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
     * @param $table
     * @return array the compiled table
     */
    private function compileTable($table)
    {
        $data = [];

        foreach($table->getColumns() as $key => $column)
        {
            $data[$key] = $column.getValue();
        }

        return $data;
    }
}