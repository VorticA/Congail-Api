<?php
/**
 * Created by PhpStorm.
 * User: viki8
 * Date: 6/8/2019
 * Time: 11:43 AM
 */

namespace App\Database;


interface iDatabaseResult
{
    public function fetchTo(string $className);
    public function fetchAllTo(string $className): array;
}