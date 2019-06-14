<?php
/**
 * Starts the session, initialises an Application and runs it.
 */

namespace App;
session_start();
spl_autoload_register();

$app = new Application();
$app->run();
