<?php
/**
 * Created by PhpStorm.
 * User: viki8
 * Date: 6/14/2019
 * Time: 9:01 PM
 */

namespace App\Service;

interface iImageUploadService
{
    public function isValidFile(array $fileData): bool;
    public function generateFileName(array $fileData);
    public function AttemptUploadFile(array $fileData, string $target): bool;
}