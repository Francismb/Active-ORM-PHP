<?php

namespace ActiveORM;

/**
 * Class Query.
 * @package ActiveORM
 */
class Queryable
{
    /**
     * @var ActiveRecordDefinition
     */
    private $definition;

    /**
     * Query constructor.
     * @param ActiveRecordDefinition $definition
     */
    public function __construct($definition)
    {
        $this->definition = $definition;
    }

    /**
     * Either updates or inserts the model depending on if the ID is present.
     */
    public function save()
    {
        if ($this->definition->getTable()->updated() && $this->valid()) {
            $row = $this->compileTable($this->definition->getTable());
            if ($this->definition->getTable()->getIdentifier()->getValue() != null) {
                ActiveRecordDB::getDatabase()->update(
                    $this->definition->getTable()->getName(),
                    $row,
                    self::createIdentifier($this->definition->getTable()->getIdentifier())
                );
                $this->definition->getTable()->refresh();
                ActiveRecordDB::getInstance()->debug();
            } else {
                ActiveRecordDB::getDatabase()->insert($this->definition->getTable()->getName(), $row);
                $this->definition->getTable()->getIdentifier()->setValue(ActiveRecordDB::getDatabase()->id());
                $this->definition->getTable()->refresh();
                ActiveRecordDB::getInstance()->debug();
            }
        }
    }

    /**
     * Generate the graph
     */
    public function saveAll()
    {
        $createdObjects = $this->getCreatedObjects($this, [spl_object_hash($this) => $this]);
    }

    private function getCreatedObjects($root, $objects) {
        foreach ($root->definition->getRelationships() as $relationship) {
            if ($relationship->hasValue()) {
                $value = $relationship->getValue();
                if (is_array($value)) {
                    $records = $value;
                    foreach ($records as $record) {
                        $objectHash = spl_object_hash($record);
                        if (!isset($objects[$objectHash])) {
                            $objects[$objectHash] = $record;
                            $objects = array_merge($objects, $this->getCreatedObjects($record, $objects));
                        }
                    }
                } else {
                    $record = $value;
                    $objectHash = spl_object_hash($record);
                    if (!isset($objects[$objectHash])) {
                        $objects[$objectHash] = $record;
                        $objects = array_merge($objects, $this->getCreatedObjects($record, $objects));
                    }
                }
            }
        }
        return $objects;
    }

    /**
     * Deletes a record from the database if it exists
     */
    public function delete() {
        if ($this->definition->getTable()->getIdentifier()->getValue() != null) {
            ActiveRecordDB::getDatabase()->delete($this->definition->getTable()->getName(), self::createIdentifier($this->definition->getTable()->getIdentifier()));
            ActiveRecordDB::getInstance()->debug();
        }
    }

    /**
     * Finds a record and creates a model instance based off an ID.
     * @param int $id The id of the record.
     * @return ActiveRecord
     */
    public static function findByID($id)
    {
        $definition = static::define();
        return self::findOne([$definition->getTable()->getIdentifier()->getName() => $id]);
    }

    /**
     * Finds a record and creates a model based off the criteria.
     * @param array $criteria The 'where' of the query.
     * @return ActiveRecord
     */
    public static function findOne($criteria)
    {
        $definition = static::define();

        $row = ActiveRecordDB::getDatabase()->get($definition->getTable()->getName(), '*', $criteria);
        ActiveRecordDB::getInstance()->debug();

        if ($row) {
            $model = new static();

            foreach ($row as $column => $value) {
                $model->definition->getTable()->getColumn($column)->setValue($value, true);
            }

            return $model;
        }

        return null;
    }

    /**
     * Finds multiple records and creates multiple models based off the criteria.
     * @param array $criteria The 'where' of the query.
     * @return \ArrayObject of ActiveORMS.
     */
    public static function findAll($criteria = [])
    {
        $definition = static::define();

        $rows = ActiveRecordDB::getDatabase()->select($definition->getTable()->getName(), '*', $criteria);
        ActiveRecordDB::getInstance()->debug();

        if ($rows) {

            $models = [];

            foreach ($rows as $row) {

                $model = new static();
                foreach ($row as $column => $value) {
                    $model->definition->getTable()->getColumn($column)->setValue($value, true);
                }
                $models[] = $model;

            }
            return new \ArrayObject($models);
        }

        return new \ArrayObject();
    }

    /**
     * Checks to see if the record exists.
     * @param array $criteria The 'where' of the query.
     * @return bool True if it exists else false.
     */
    public static function exists($criteria)
    {
        $definition = static::define();
        return ActiveRecordDB::getDatabase()->has($definition->getTable()->getName(), $criteria);
    }

    /**
     * Gets the amount of records that match the criteria.
     * @param array $criteria The 'where' of the query.
     * @return int The amount of records.
     */
    public static function count($criteria = [])
    {
        $definition = static::define();
        return ActiveRecordDB::getDatabase()->count($definition->getTable()->getName(), $criteria);
    }

    /**
     * Compiles a Table object into an associative array
     * @param \ActiveORM\Definition\Table $table
     * @return array the compiled table
     */
    private function compileTable($table)
    {
        $data = [];

        foreach($table->getColumns() as $column) {
            $data[$column->getColumnName()] = $column->getValue();
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