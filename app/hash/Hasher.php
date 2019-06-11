<?php


namespace App\Hash;


class Hasher implements iHasher
{
    private $codeword;
    /**
     * @var int
     */
    private $algo;

    public function __construct(string $codeword, int $algo)
    {
        $this->codeword=$codeword;
        $this->algo = $algo;
    }

    public function EncodePassword(string $password): string
    {
        return password_hash($this->codeword.$password, $this->algo);
    }

    public function MatchPasswords(string $password, string $hash): bool
    {
        return password_verify($this->codeword.$password, $hash);
    }
}