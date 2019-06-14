<?php
/**
 * A hasher class used for encoding strings based on the given "codeword" and algorithm
  */


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

    /*
     * Encodes a given string
     */
    public function EncodePassword(string $password): string
    {
        return password_hash($this->codeword.$password, $this->algo);
    }

    /*
     * Checks if a given string matches a given hash
     */
    public function MatchPasswords(string $password, string $hash): bool
    {
        return password_verify($this->codeword.$password, $hash);
    }
}