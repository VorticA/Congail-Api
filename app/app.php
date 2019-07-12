<?php
/**
 * Starts the session, initialises an Application and runs it.
 */

namespace App;
session_start();
use App\Hash\Hasher;
use App\Service\ImageUploadService;

spl_autoload_register(function($data) {
    $data = str_replace("App\\", "", $data);
    $expl = explode("\\", $data);
    $className = array_pop($expl);
    include_once(__DIR__ . DIRECTORY_SEPARATOR . strtolower(implode($expl, DIRECTORY_SEPARATOR)) . DIRECTORY_SEPARATOR . $className . '.php');
});
include_once ('config.php');

$app = new Application();
$app->run();






