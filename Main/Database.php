<?php

namespace Main;

use Main\Config;
use Main\Format;
use PDO;
use Exception;

class Database
{

    /**
     * PDO database connection.
     * @var PDO
     */
    private static $connection;

    /**
     *
     * @var PDOStatement
     */
    private static $statement;

    public static function connect()
    {
        self::$connection = new PDO('mysql:dbname=' . Config::getValue('database.name') . ';host=' . Config::getValue('database.host'), Config::getValue('database.username'), Config::getValue('database.password'));
        self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public static function query($query, array $params = null)
    {
        if (!self::$connection) {
            self::connect();
        }

        self::$statement = self::$connection->prepare($query);

        if ($params) {
            self::$statement = self::setParams($params);
        }

        return self::$statement->execute();
    }

    private static function setParams(array $params)
    {
        foreach ($params as $key => $param) {
            if (is_numeric($param) && !is_float($param)) {
                self::$statement->bindParam($key, $param, PDO::PARAM_INT);
            } else {
                self::$statement->bindParam($key, $param, PDO::PARAM_STR);
            }
        }

        return true;
    }

    public static function fetch()
    {
        if (empty(self::$statement)) {
            throw new Exception('No SQL statement set.');
        }

        return self::$statement->fetch(PDO::FETCH_ASSOC);
    }

    public static function fetchObject($class)
    {
        $values = self::fetch();

        if (!$values) {
            return null;
        }

        if (!class_exists($class)) {
            throw new Exception('Class ' . $class . ' does not exist');
        }

        $object = new $class;

        foreach ($values as $key => $value) {
            $method = Format::underscoreToCamelCase('set' . $key, false);
            if (method_exists($object, $method)) {
                $object->$method($value);
            }
        }

        return $object;
    }
}
