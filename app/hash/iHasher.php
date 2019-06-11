<?php


namespace App\Hash;


interface iHasher
{
    public function EncodePassword(string $password): string;
    public function MatchPasswords(string $password, string $hash): bool;
}