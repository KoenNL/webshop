<?php

namespace Main;

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
     * Prepared PDO SQL statement.
     * @var PDOStatement
     */
    private static $statement;

    public static function connect()
    {
        self::$connection = new PDO('mysql:dbname=' . Config::getValue('database.name') . ';host=' . Config::getValue('database.host'), Config::getValue('database.username'), Config::getValue('database.password'));
        self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    /**
     * Send an SQL query to the database.
     * @param $query
     * @param array|null $params
     * @return bool
     */
    public static function query($query, array $params = null)
    {
        if (!self::$connection) {
            self::connect();
        }

        self::$statement = self::$connection->prepare($query);

        if ($params) {
            self::setParams($params);
        }

        return self::$statement->execute();
    }

    /**
     * Add the parameters to the prepared SQL statement.
     * @param array $params
     * @return bool
     */
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

    /**
     * Fetch a new row from the result set as an array.
     * @return array
     * @throws Exception
     */
    public static function fetch()
    {
        if (empty(self::$statement)) {
            throw new Exception('No SQL statement set.');
        }

        return self::$statement->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Fetch a new row from the result set as an object of the given class.
     * @param string $class
     * @return object
     * @throws Exception
     */
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

    /**
     * Returns the id of the last inserted entry into the database.
     * @return int
     */
    public static function getLastInsertId()
    {
        return (int) self::$connection->lastInsertId();
    }
}
