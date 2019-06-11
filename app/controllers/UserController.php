<?php
/**
 * Created by PhpStorm.
 * User: viki8
 * Date: 6/10/2019
 * Time: 11:28 AM
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
            if ($this->hasher->MatchPasswords($data['password'], $user->getPassword()))
            {
                echo json_encode(['hasUser' => true, 'username' => $user->getUsername(), 'email' => $user->getEmail(), 'role' => $user->getRoleId()]);
            }
            else echo json_encode(['hasUser' => false]);
        }
        else echo json_encode(['hasUser' => false]);
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