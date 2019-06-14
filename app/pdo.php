<?php
/**
 * Attempts a PDO connection, in case it throws an exception, throw a new one with obscure information in order to hide info.
 */
include_once ('config.php');



$pdo = null;
try
{
    $testpdo = new PDO("mysql:host=" . DB_URL . ";port=" . DB_PORT . ";dbname=" . DB_NAME, DB_USERNAME, DB_PASSWORD);
    $pdo=$testpdo;
}
catch(Exception $e)
{
    throw new Exception("Error connecting to database.");
}