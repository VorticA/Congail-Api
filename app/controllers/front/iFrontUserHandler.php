<?php
/**
 * Created by PhpStorm.
 * User: viki8
 * Date: 6/10/2019
 * Time: 11:23 AM
 */

namespace App\Controllers\Front;

interface iFrontUserHandler
{
    public function registerHandler();
    public function loginHandler();
    public function homeHandler();
}