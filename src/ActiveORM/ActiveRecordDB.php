<?php

/**
 * Created by PhpStorm.
 * User: francis
 * Date: 3/16/17s
 * Time: 10:11 AM
 */
namespace ActiveORM;
class ActiveRecordDB
{

    private $type;
    private $name;
    private $host;
    private $username;
    private $password;
    private $charset;
    private $arguments;

    private static $instance = null;

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

        $GLOBALS["database"] = new \Medoo\Medoo($arguments);
    }

    public static function initialize($arguments)
    {
        if (static::$instance != null)
        {
            return static::$instance;
        }
        static::$instance = new self($arguments);
        return static::$instance;
    }

    public static function getInstance()
    {
        return static::$instance;
    }
}