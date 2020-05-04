<?php

namespace Http;

use HttpException;
use function curl_close;
use function curl_exec;
use function curl_init;
use function curl_setopt_array;

class Request
{
    /**
     * I'd use some lib like Symphony client
     * @param $url
     * @return string
     * @throws HttpException
     */
    public function get($url): string
    {
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_POST => 0,
            CURLOPT_HEADER => 0,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => $url
        ]);
        $result = curl_exec($curl);

        curl_close($curl);
        if(curl_errno($curl)) {
            throw new HttpException('Failed to connect to API');
        }
        if(curl_getinfo($curl, CURLINFO_HTTP_CODE !== 200)) {
            throw new HttpException('API returned non-200 code');
        }
        return $result;
    }

    /**
     * @param $url
     * @param $data
     * @return string
     * @throws HttpException
     */
    public function post($url, $data): string
    {
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_POST => 1,
            CURLOPT_HEADER => 0,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => $url,
            CURLOPT_POSTFIELDS => $data,
        ]);
        $result = curl_exec($curl);
        curl_close($curl);
        if(curl_errno($curl)) {
            throw new HttpException('Failed to connect to API');
        }
        if(curl_getinfo($curl, CURLINFO_HTTP_CODE !== 200)) {
            throw new HttpException('API returned non-200 code');
        }
        return $result;
    }
}
