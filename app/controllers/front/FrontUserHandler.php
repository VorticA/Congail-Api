<?php
/**
 * Created by PhpStorm.
 * User: viki8
 * Date: 6/10/2019
 * Time: 3:58 PM
 */

namespace App\Controllers\Front;


use App\Controllers\iUserController;
use Exception;

class FrontUserHandler implements iFrontUserHandler
{
    /**
     * @var iUserController
     */
    private $controller;
    /**
     * @var array
     */
    private $post;
    /**
     * @var array
     */
    private $session;

    public function __construct(iUserController $controller, array $post, array $session)
    {
        $this->controller = $controller;
        $this->post = $post;
        $this->session = $session;
    }

    public function registerHandler()
    {
        if (isset($this->session['userId']) && isset($this->session['password']))
            throw new Exception("User already logged in!");
        else
        {
            if (!$this->post) throw new Exception("Invalid info. ");
            $this->controller->register($this->post);
        }
    }

    public function loginHandler()
    {
        if (isset($this->session['userId']) && isset($this->session['password']))
            throw new Exception("User already logged in!");
        else
        {
            if (!$this->post) throw new Exception("Invalid info!");
            $this->controller->logInSession($this->post);
        }
    }

    public function homeHandler()
    {
        if (isset($this->session['userId']) && isset($this->session['password']))
        {
            $this->controller->getLoggedUserJson($this->session);
        }
        else
            throw new Exception("User not logged in.");
    }
}