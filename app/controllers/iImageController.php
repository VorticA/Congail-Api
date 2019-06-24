<?php
/**
 * Created by PhpStorm.
 * User: viki8
 * Date: 6/23/2019
 * Time: 12:36 PM
 */

namespace App\Controllers;


interface iImageController
{
    public function uploadImage(array $imageData, array $files, array $userData);
    public function getFullGallery();
    public function deleteImage(int $id, array $userData);
    public function editImage(array $imageData, array $userData);
}