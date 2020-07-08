<?php

namespace App\Api\Request;

class RequestFactory
{
    /**
     * @param string $body
     * @param array $headers
     * @param string $method
     * @param string $query
     * @param string $url
     * @return \App\Api\Request\Request
     */
    public function create(string $body, array $headers, string $method, string $query, string $url): Request
    {
        $body = json_decode($body) ?? (object) $body;
        $domain = explode(".", parse_url($url, PHP_URL_HOST));
        $domain = end($domain);
        $path = parse_url($url, PHP_URL_PATH);
        $query = json_decode($query) ?? (object) $query;
        $scheme = parse_url($url, PHP_URL_SCHEME);

        return new Request($body, $domain, $headers, $method, $path, $query, $scheme, $url);
    }
}