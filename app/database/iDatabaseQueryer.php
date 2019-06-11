<?php
/**
 * Created by PhpStorm.
 * User: viki8
 * Date: 6/8/2019
 * Time: 11:42 AM
 */

namespace App\Database;


interface iDatabaseQueryer
{
    public function prepare(string $query): iDatabaseStatement;
}