<?php
/**
 * The main LOGIC entry point of the application, no arguments are passed
 * to this class. It consists of a try catch block. If an exception is thrown
 * somewhere down the stream of class initializations and method calls
 * it returns the exception's message as a JSON.
 */

namespace App;


use App\Controllers\Front\FrontImageHandler;
use App\Controllers\ImageController;
use App\Database\DatabaseQueryer;
use App\Hash\Hasher;
use App\Models\Image;
use App\Repos\ImageRepository;
use App\Repos\UserRepository;
use App\Service\ImageUploadService;

class Application
{
    /**
     * Where all the magic begins.
     */
    public function run(){
        try
        {
            include_once('pdo.php');

            $router = new Router(new ControllerFactory($pdo));
            $router->Route();

        }
        catch (\Exception $e)
        {
            echo json_encode(['error' => $e->getMessage()]);
        }
    }
}