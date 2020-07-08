<?php

namespace App\Api\Response;

class ResponseFactory
{
    /**
     * @param int $code
     * @param array $headers
     * @param object $body
     * @return \App\Api\Response\Response
     */
    public function create(int $code, array $headers, object $body): Response
    {
        return new Response($code, $headers, $body);
    }
}