<?php
/**
 * Created by PhpStorm.
 * User: viki8
 * Date: 6/8/2019
 * Time: 11:53 AM
 */

namespace App\Database;


class DatabaseStatement implements iDatabaseStatement
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
     * Returns a result class.
     */
    public function execute(array $params=null): iDatabaseResult
    {
        if (is_null($params))
        {
            $this->stmt->execute();
        }
        else $this->stmt->execute($params);
        return new DatabaseResult($this->stmt);
    }
}