<?php
/**
 * Created by PhpStorm.
 * User: viki8
 * Date: 6/8/2019
 * Time: 11:49 AM
 */

namespace App\Database;

class DatabaseQueryer implements iDatabaseQueryer
{
    /**
     * @var \PDO
     */
    private $pdo;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
        $this->pdo->setAttribute(\PDO::ATTR_EMULATE_PREPARES, FALSE);
    }


    /**
     * Returns a prepared statement class;
     */
    public function prepare(string $query): iDatabaseStatement
    {
        return new DatabaseStatement($this->pdo->prepare($query));
    }
}