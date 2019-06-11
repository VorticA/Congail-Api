<?php
/**
 * Created by PhpStorm.
 * User: viki8
 * Date: 6/8/2019
 * Time: 11:50 AM
 */

namespace App\Database;


class DatabaseResult implements iDatabaseResult
{
    /**
     * @var \PDOStatement
     */
    private $stmt;

    public function __construct(\PDOStatement $stmt)
    {
        $this->stmt = $stmt;
    }



    /**
     * Fetches the prepared statement result to a specified class.
     */
    public function fetchTo(string $className)
    {
        $this->stmt->setFetchMode(\PDO::FETCH_CLASS|\PDO::FETCH_PROPS_LATE, $className);
        $res = $this->stmt->fetch();
        if($res) return $res;
        return null;
    }

    /**
     * Fetches the prepared statement result to an array of the specified class.
     */
    public function fetchAllTo(string $className): array
    {
        return $this->stmt->fetchAll(\PDO::FETCH_CLASS|\PDO::FETCH_PROPS_LATE, $className);
    }
}