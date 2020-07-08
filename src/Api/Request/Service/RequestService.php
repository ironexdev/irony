<?php

namespace App\Api\Request\Service;

use App\Api\Exception\Http\UnprocessableEntityException;
use App\Api\Exception\Http\UnsupportedMediaTypeException;
use App\Api\Request\Request;
use App\Api\Service\ApiService;

class RequestService
{
    /**
     * @var \App\Api\Service\ApiService
     */
    private $apiService;

    /**
     * RequestService constructor.
     * @param \App\Api\Service\ApiService $apiService
     */
    public function __construct(ApiService $apiService)
    {
        $this->apiService = $apiService;
    }

    /**
     * @param \App\Api\Request\Request $request
     * @param array $routeDefinition
     * @throws \App\Api\Exception\Http\BadRequestException
     * @throws \App\Api\Exception\Http\UnprocessableEntityException
     * @throws \App\Api\Exception\Http\UnsupportedMediaTypeException
     */
    public function validateRequest(Request $request, array $routeDefinition): void
    {
        $result = [];

        $this->validateRequestFormat($request);

        if (isset($routeDefinition["query"]))
        {
            $queryValidationResult = $this->apiService->validateObject($request->getQuery(), $routeDefinition["query"]);

            if ($queryValidationResult)
            {
                $result["query"] = $queryValidationResult;
            }
        }

        if (isset($routeDefinition["body"]))
        {
            $bodyValidationResult = $this->apiService->validateObject($request->getBody(), $routeDefinition["body"]);

            if ($bodyValidationResult)
            {
                $result["body"] = $bodyValidationResult;
            }
        }

        if ($result)
        {
            throw new UnprocessableEntityException("", ["errors" => $result]);
        }
    }

    /**
     * @param \App\Api\Request\Request $request
     * @throws \App\Api\Exception\Http\UnsupportedMediaTypeException
     */
    private function validateRequestFormat(Request $request)
    {
        $requestContentType = $request->getHeaders()["Content-Type"] ?? null;

        if ($request->getBody() && $requestContentType !== "application/json")
        {
            throw new UnsupportedMediaTypeException("Requests with body have to specify Content-Type header application/json.");
        }
    }
}