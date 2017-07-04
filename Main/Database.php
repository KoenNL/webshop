<?php

namespace Main;

use PDO;
use PDOStatement;
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
     * @return PDOStatement
     */
    public static function query($query, array $params = null)
    {
        if (!self::$connection) {
            self::connect();
        }

        $statement = self::$connection->prepare($query);

        if ($params) {
            self::setParams($statement, $params);
        }

        return $statement->execute() ? $statement : null;
    }

    /**
     * Add the parameters to the prepared SQL statement.
     * @param array $params
     * @return bool
     */
    private static function setParams(PDOStatement $statement, array $params)
    {
        foreach ($params as $key => $param) {
            if (is_numeric($param) && !is_float($param)) {
                $statement->bindValue($key, $param, PDO::PARAM_INT);
            } else {
                $statement->bindValue($key, $param, PDO::PARAM_STR);
            }
        }

        return true;
    }

    /**
     * Fetch a new row from the result set as an array.
     * @return array
     */
    public static function fetch(PDOStatement $statement)
    {
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Fetch all rows of the result set as an associative array.
     * @return array
     */
    public static function fetchAll(PDOStatement $statement)
    {
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /**
     * Fetch a new row from the result set as an object of the given class.
     * @param string $class
     * @return object
     * @throws Exception
     */
    public static function fetchObject(PDOStatement $statement, $class)
    {
        $values = self::fetch($statement);

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

    /**
     * Returns the amount of inserted, updated, deleted or selected rows depending on the preceding query.
     * @return int
     */
    public static function getRowCount(PDOStatement $statement)
    {
        return (int) $statement->rowCount();
    }
}
