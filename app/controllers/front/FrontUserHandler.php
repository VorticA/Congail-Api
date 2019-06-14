<?php
/**
 * An HTTP handler for User requests
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

    /**
     * Handles a register attempt.
     */
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

    /**
     * Handles a login attempt
     */
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

    /**
     * Handles a "home" attempt, meaning it handles an attempt to get the logged user JSON
     */
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