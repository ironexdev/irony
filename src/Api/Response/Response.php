<?php

namespace App\Api\Response;

use App\Config\Config;
use App\Enum\ResponseHeaderEnum;

class Response
{
    /**
     * @var object
     */
    private $body;

    /**
     * @var int
     */
    private $code;

    /**
     * @var array
     */
    private $headers;

    /**
     * Response constructor.
     * @param int $code
     * @param array $headers
     * @param object $body
     */
    public function __construct(int $code, array $headers, object $body)
    {
        $headers[ResponseHeaderEnum::ACCESS_ALLOW_CONTROL_ORIGIN] = Config::getAccessControlAllowOrigin();

        $this->code = $code;
        $this->headers = $headers;
        $this->body = $body;
    }

    /**
     * @return object
     */
    public function getBody(): object
    {
        return $this->body;
    }

    /**
     * @return int
     */
    public function getCode(): int
    {
        return $this->code;
    }

    /**
     * @return array
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }
}