<?php
/**
 * Created by PhpStorm.
 * User: viki8
 * Date: 6/11/2019
 * Time: 3:11 PM
 */

namespace App\Models;


interface iArticle
{
    public function getId();
    public function getTitle();
    public function getText();
    public function getPostDate();
    public function getPosterId();
    public function getIsDeleted();
}