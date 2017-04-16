<?php

namespace ActiveORM;

/**
 * Class ActiveRecordDB.
 * @package ActiveORM
 */
class ActiveRecordDB
{

    /**
     * @var string database type.
     */
    private $type;

    /**
     * @var string database name.
     */
    private $name;

    /**
     * @var string database host.
     */
    private $host;

    /**
     * @var string database username.
     */
    private $username;

    /**
     * @var string database password.
     */
    private $password;

    /**
     * @var string database charset.
     */
    private $charset;

    /**
     * @var array arguments passed into the constructor.
     */
    private $arguments;

    /**
     * @var \Medoo\Medoo The database intance.
     */
    private $database;

    /**
     * @var ActiveRecordDB The singleton instance.
     */
    private static $instance = null;

    /**
     * ActiveRecordDB constructor.
     * @param array $arguments the database arguments.
     */
    private function __construct($arguments)
    {
        $this->arguments = $arguments;
        foreach ($arguments as $key => $value)
        {
            switch ($key)
            {
                case "database_type":
                    $this->type = $value;
                    break;
                case "database_name":
                    $this->name = $value;
                    break;
                case "server":
                    $this->host = $value;
                    break;
                case "username":
                    $this->username = $value;
                    break;
                case "password":
                    $this->password = $value;
                    break;
                case "charset":
                    $this->charset = $value;
                    break;
            }
        }

        $this->database = new \Medoo\Medoo($arguments);
    }

    /**
     * @param array $arguments
     * @return ActiveRecordDB
     */
    public static function initialize($arguments)
    {
        if (static::$instance != null)
        {
            return static::$instance;
        }
        static::$instance = new self($arguments);
        return static::$instance;
    }

    /**
     * @return ActiveRecordDB
     */
    public static function getInstance()
    {
        return static::$instance;
    }

    /**
     * @return \Medoo\Medoo
     */
    public static function getDatabase() {
        return self::getInstance()->database;
    }

    public function debug()
    {
        echo $this->database->last() . "\n";
    }
}