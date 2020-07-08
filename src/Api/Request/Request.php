<?php

namespace App\Api\Request;

class Request
{
    /**
     * @var object
     */
    private $body;

    /**
     * @var string
     */
    private $domain;

    /**
     * @var array
     */
    private $headers;

    /**
     * @var string
     */
    private $method;

    /**
     * @var string
     */
    private $path;

    /**
     * @var object
     */
    private $query;

    /**
     * @var string
     */
    private $rawBody;

    /**
     * @var string
     */
    private $scheme;

    /**
     * @var string
     */
    private $url;

    /**
     * Request constructor.
     * @param object $body
     * @param string $domain
     * @param array $headers
     * @param string $method
     * @param string $path
     * @param object $query
     * @param string $scheme
     * @param string $url
     */
    public function __construct(object $body, string $domain, array $headers, string $method, string $path, object $query, string $scheme, string $url)
    {
        $this->body = $body;
        $this->domain = $domain;
        $this->headers = $headers;
        $this->method = $method;
        $this->path = $path;
        $this->query = $query;
        $this->scheme = $scheme;
        $this->url = $url;
    }

    /**
     * @return object
     */
    public function getBody(): object
    {
        return $this->body;
    }

    /**
     * @return string
     */
    public function getDomain(): string
    {
        return $this->domain;
    }

    /**
     * @return array
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @return object
     */
    public function getQuery(): object
    {
        return $this->query;
    }

    /**
     * @return string
     */
    public function getRawBody(): string
    {
        return $this->rawBody;
    }

    /**
     * @return string
     */
    public function getScheme(): string
    {
        return $this->scheme;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }
}