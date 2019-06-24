<?php
/**
 * Created by PhpStorm.
 * User: viki8
 * Date: 6/15/2019
 * Time: 3:34 PM
 */

namespace App\Models;


interface iImage
{
    public function getId();
    public function getImagePath();
    public function getImageTitle();
    public function getImageDescription();
    public function getUploadDate();
    public function getIsDeleted();
    public function getPosterId();
}