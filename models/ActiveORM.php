<?php
/**
 * Created by PhpStorm.
 * User: francis
 * Date: 2/28/17
 * Time: 1:48 PM
 */
class ActiveORM
{
    /**
     * A mapping between column name and the value of the column.
     */
    private $mapping;

    /**
     * Finds a record and creates a model instance based off an ID.
     * @param $id - id of the record.
     * @return ActiveORM
     */
    public static function findByID($id) {
        return self::findOne(["id" => $id]);
    }

    /**
     * Finds a record and creates a model based off the criteria.
     * @param $criteria - The 'where' of the query.
     * @return ActiveORM
     */
    public static function findOne($criteria) {
        $row = $GLOBALS['database']->get(static::$table, '*', $criteria);

        if ($row) {
            $model = new static();

            foreach ($row as $column => $value) {
                $model->__set($column, $value);
            }

            return $model;
        }

        return $row;
    }

    /**
     * Finds multiple records and creates multiple models based off the criteria.
     * @param $criteria - The 'where' of the query.
     * @return array of ActiveORMS.
     */
    public static function findAll($criteria) {
        $rows = $GLOBALS['database']->select(static::$table, '*', $criteria);

        if ($rows) {
            $models = [];

            foreach ($rows as $row) {
                $model = new static();
                foreach ($row as $column => $value) {
                    $model->__set($column, $value);
                }
                $models[] = $model;
            }

            return $models;
        }

        return $rows;
    }

    /**
     * Either updates or inserts the model depending on if the ID is present.
     */
    public function save()
    {
        if (isset($this->mapping['id'])) {
            $GLOBALS['database']->update(static::$table, $this->mapping, ['id' => $this->mapping['id']]);
        } else {
            $GLOBALS['database']->insert(static::$table, $this->mapping);
        }
    }

    /**
     * Deletes a record from the database if it exists
     */
    public function delete() {
        if (isset($this->mapping['id'])) {
            $GLOBALS['database']->delete(static::$table, ['id' => $this->mapping['id']]);
        }
    }

    /**
     * Overriding the set magic method to save mappings
     * @param $name the name of the field
     * @param $value the value of the field
     */
    public function __set($name, $value)
    {
        $this->mapping[$name] = $value;
    }

    /**
     * Overriding the get magic method to give proper values
     * @param $name the name of the field
     */
    public function __get($name) {
        return $this->mapping[$name];
    }
}