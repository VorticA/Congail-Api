<?php
/**
 * Created by PhpStorm.
 * User: viki8
 * Date: 6/8/2019
 * Time: 11:31 AM
 */

namespace App\Models;


class User implements iUser
{

    /**
     * @var int
     */
    private $id;
    /**
     * @var string
     */
    private $username;
    /**
     * @var string
     */
    private $email;
    /**
     * @var string
     */
    private $password;
    /**
     * @var int
     */
    private $roleId;
    /**
     * @var string
     */
    private $confirmPassword;
    /**
     * @var string
     */
    private $confirmEmail;

    public function __construct(string $username="", string $password="", string $confirmPassword="", string $email="", string $confirmEmail="")
    {
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
        $this->confirmPassword = $confirmPassword;
        $this->confirmEmail = $confirmEmail;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getRoleId()
    {
        return $this->roleId;
    }

    function getConfirmEmail()
    {
        return $this->confirmEmail;
    }

    function getConfirmPassword()
    {
        return $this->confirmPassword;
    }
}