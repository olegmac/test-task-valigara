<?php


namespace Api\Amazon;


class Signature
{
    const METHOD = 'HmacSHA256';
    const VERSION = 2;

    public static function get(string $queryString, string $key): string
    {
        return hash_hmac('sha256', $queryString, $key);
    }
}
