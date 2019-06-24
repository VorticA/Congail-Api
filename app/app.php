<?php
/**
 * Starts the session, initialises an Application and runs it.
 */

namespace App;
use App\Hash\Hasher;
use App\Service\ImageUploadService;

session_start();
spl_autoload_register();
include_once ('config.php');

$app = new Application();
$app->run();




