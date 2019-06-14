<?php
/**
 * Created by PhpStorm.
 * User: viki8
 * Date: 6/14/2019
 * Time: 12:56 PM
 */

namespace App\Controllers\Front;


interface iFrontArticleHandler
{
    public function latestHandler();
    public function editHandler();
    public function uploadHandler();
    public function deleteHandler();
}