<?php
/**
 * Created by PhpStorm.
 * User: viki8
 * Date: 6/15/2019
 * Time: 3:21 PM
 */

namespace App\Repos;


use App\Models\iImage;

interface iImageRepository
{
    public function getImageById($id);
    public function uploadImage(iImage $image);
    public function updateImage(iImage $image, int $id);
    public function deleteImageById($id);
    public function getFullGallery();
}