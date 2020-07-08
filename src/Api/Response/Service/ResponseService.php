<?php

namespace App\Api\Response\Service;

use App\Api\Response\Response;
use App\Enum\ResponseHeaderEnum;
use App\Enum\ResponseStatusCodeGroupEnum;
use Error;

class ResponseService
{
    /**
     * @param \App\Api\Response\Response $response
     */
    public function sendResponse(Response $response): void
    {
        $this->validateResponseCode($response->getCode());
        $this->validateResponseHeaders($response->getHeaders());

        $bodyAsString = json_encode($response->getBody(), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);

        http_response_code($response->getCode()); // set response code

        foreach ($response->getHeaders() as $key => $value) // set headers
        {
            header($key . ":" . $value);
        }

        if (!in_array(ResponseHeaderEnum::CONTENT_LENGTH, $response->getHeaders(), true)) // set Content-Length header if it is not set
        {
            header(ResponseHeaderEnum::CONTENT_LENGTH . ":" . strlen($bodyAsString));
        }

        header(ResponseHeaderEnum::CONTENT_TYPE . ":application/json; charset=utf-8"); // set Content-Type header with encoding

        echo $bodyAsString;
        exit;
    }

    /**
     * @param $headerName
     * @return bool
     */
    private function isValidResponseHeaderName(string $headerName): bool
    {
        return in_array($headerName, ResponseHeaderEnum::getConstants(), true);
    }

    /**
     * @param int $code
     * @return bool
     */
    private function isValidResponseCode(int $code): bool
    {
        $validCodes = array_merge(ResponseStatusCodeGroupEnum::INFORMATIONAL, ResponseStatusCodeGroupEnum::SUCCESS, ResponseStatusCodeGroupEnum::CLIENT_ERROR, ResponseStatusCodeGroupEnum::SERVER_ERROR);

        return in_array($code, $validCodes, true);
    }

    /**
     * @param int $code
     */
    private function validateResponseCode(int $code): void
    {
        if (!$this->isValidResponseCode($code))
        {
            throw new Error("Invalid response code - " . $code . ".");
        }
    }

    /**
     * @param array $headers
     */
    private function validateResponseHeaders(array $headers): void
    {
        foreach ($headers as $headerName => $headerValue)
        {
            if (!$this->isValidResponseHeaderName($headerName))
            {
                throw new Error("Invalid header name - " . $headerName . ".");
            }
        }
    }
}