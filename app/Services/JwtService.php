<?php

namespace App\Services;

use Firebase\JWT\JWT;

class JwtService
{
    protected $algorithm;

    protected $key;

    /**
     * @param string $algorithm
     * @param string $key
     */
    public function __construct($algorithm, $key)
    {
        $this->algorithm = $algorithm;
        $this->key = $key;
    }

    /**
     * @param  array  $payload
     * @param  int    $time
     * @return string
     */
    public function generateToken(array $payload, int $time)
    {
        $realPayload = [
            'data' => $payload,
            'iat' => time(),
            'exp' => time() + $time,
        ];

        return JWT::encode($realPayload, $this->key);
    }
}
