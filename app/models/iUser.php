<?php
/**
 * Created by PhpStorm.
 * User: viki8
 * Date: 6/8/2019
 * Time: 11:00 AM
 */

namespace App\Models;


interface iUser
{
    function getId();
    function getUsername();
    function getEmail();
    function getConfirmEmail();
    function getPassword();
    function getConfirmPassword();
    function getRoleId();
}