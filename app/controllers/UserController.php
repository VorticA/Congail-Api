<?php
/**
 * An MVC controller class for handling outside requests related to the database
 */

namespace App\Controllers;


use App\Hash\iHasher;
use App\Models\iUser;
use App\Models\User;
use App\Repos\iUserRepository;
use Exception;

class UserController implements iUserController
{
    /**
     * @var iUserRepository
     */
    private $repository;
    /**
     * @var iHasher
     */
    private $hasher;

    public function __construct(iUserRepository $repository, iHasher $hasher)
    {
        $this->repository = $repository;
        $this->hasher = $hasher;
    }

    /**
     * Attempts to register a User to the DB
     */
    public function register(array $data)
    {
        $user = new User($data['username'], $this->hasher->EncodePassword($data['password']), $data['confirmPassword'], $data['email'], $data['confirmEmail']);
        if ($this->usernameTaken($user)) throw new Exception("Username ".$user->getUsername()." already taken.");
        if ($this->emailTaken($user)) throw new Exception("Email ".$user->getEmail()." already taken.");
        if ($this->validate($user))
        {
            $this->repository->importUser($user);
        }
    }

    /**
     * Logs the given user in the session if he exists
     */
    public function logInSession(array $data)
    {
        $user = $this->repository->getUserByUsername($data['username']);
        if ($user==null || !$this->hasher->MatchPasswords($data['password'], $user->getPassword()))
        {
            throw new Exception('Invalid username and/or password!');
        }
        else {
            $_SESSION['userId']=$user->getId();
            $_SESSION['password']=$data['password'];
            throw new \Exception(var_export($_SESSION, true));
        }
    }

    /**
     * If there is a logged user in the session it returns it as a JSON object
     */
    public function getLoggedUserJson(array $data)
    {
        if (isset($data['userId']) && isset($data['password']))
        {
            $user = $this->repository->getUserById($data['userId']);

            if (isset($user)) {
                if ($this->hasher->MatchPasswords($data['password'], $user->getPassword())) {
                    echo json_encode(['hasUser' => true, 'user' => ['id' => $user->getId(), 'username' => $user->getUsername(), 'email' => $user->getEmail(), 'role' => $user->getRoleId()]]);
                } else throw new Exception("Invalid credentials!");
            }
            else throw new Exception("Invalid credentials.");
        }
        else throw new Exception("Invalid credentials.");
    }

    /**
     * Checks if the attempted username is taken
     */
    private function usernameTaken(iUser $user): bool
    {
        $getUserAttempt = $this->repository->getUserByUsername($user->getUsername());
        if ($getUserAttempt===null)
        {
            return false;
        }
        return true;
    }

    /**
     * Checks if the attempted email is taken
     */
    private function emailTaken(iUser $user): bool
    {
        $getUserAttempt = $this->repository->getUserByEmail($user->getEmail());
        if ($getUserAttempt===null)
        {
            return false;
        }
        return true;
    }

    /**
     * Privately validates wether the proper fields match
     */
    private function validate(iUser $user): bool
    {
        if ($user->getPassword()==null || $user->getUsername()==null || $user->getEmail()==null
            || $user->getConfirmPassword()==null
            || $user->getConfirmEmail()==null)
        {
            throw new Exception("There are empty fields in the form.");
            return false;
        }
        if (!$this->hasher->MatchPasswords($user->getConfirmPassword(),$user->getPassword()))
        {
            throw new Exception("Passwords do not match.");
            return false;
        }
        if ($user->getEmail()!=$user->getConfirmEmail())
        {
            throw new Exception("Emails do not match.");
            return false;
        }
        return true;
    }
}