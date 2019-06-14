<?php
/**
 * Created by PhpStorm.
 * User: viki8
 * Date: 6/14/2019
 * Time: 9:01 PM
 */

interface iImageUploadService
{
    public function AttemptUploadFile(array $fileData): bool;
}