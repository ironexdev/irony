<?php

namespace App\Api\Controller;

use App\Api\User\User;
use App\Enum\ResponseStatusCodeEnum;
use App\Api\Request\Request;
use App\Api\Response\Response;
use App\Api\Response\ResponseFactory;
use App\Model\Service\EntityManagerService;

abstract class AbstractController
{
    /**
     * @var EntityManagerService
     */
    protected $entityManagerService;

    /**
     * @var Request
     */
    protected $request;

    /**
     * @var User
     */
    protected $user;

    /**
     * @var ResponseFactory
     */
    private $responseFactory;

    /**
     * AbstractController constructor.
     * @param \App\Model\Service\EntityManagerService $entityManagerService
     * @param \App\Api\Request\Request $request
     * @param \App\Api\Response\ResponseFactory $responseFactory
     * @param \App\Api\User\User $user
     */
    public function __construct(EntityManagerService $entityManagerService, Request $request, ResponseFactory $responseFactory, User $user)
    {
        $this->entityManagerService = $entityManagerService;
        $this->request = $request;
        $this->responseFactory = $responseFactory;
        $this->user = $user;
    }

    /**
     * @param object $body
     * @param int $code
     * @param array $headers
     * @return \App\Api\Response\Response
     */
    public function response(object $body, int $code = ResponseStatusCodeEnum::OK, array $headers = []): Response
    {
        return $this->responseFactory->create($code, $headers, $body);
    }
}