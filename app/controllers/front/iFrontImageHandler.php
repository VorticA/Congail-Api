<?php
/**
 * Created by PhpStorm.
 * User: viki8
 * Date: 6/24/2019
 * Time: 9:08 AM
 */

namespace App\Controllers\Front;


interface iFrontImageHandler
{
    public function galleryHandler();
    public function editHandler();
    public function uploadHandler();
    public function deleteHandler();
}