<?php

namespace App\Api;

use App\Api\Exception\Http\AbstractHttpClientException;
use App\Api\Exception\Http\ForbiddenException;
use App\Api\Exception\Http\MethodNotAllowedException;
use App\Api\Exception\Http\NotFoundException;
use App\Api\Exception\Http\UnauthorizedException;
use App\Api\Request\Request;
use App\Api\Request\RequestFactory;
use App\Api\Request\Service\RequestService;
use App\Api\Response\Response;
use App\Api\Response\ResponseFactory;
use App\Api\Response\Service\ResponseService;
use App\Api\Router\Router;
use App\Api\User\User;
use App\Enum\RequestMethodEnum;
use App\Enum\ResponseHeaderEnum;
use App\Enum\ResponseStatusCodeEnum;
use App\FileSystem\Filesystem;
use App\Model\Repository\AuthenticationTokenRepository;
use App\Translator\Translator;
use DateTime;
use DateTimeZone;
use DI\Container;

class Api
{
    /**
     * @var AuthenticationTokenRepository
     */
    private $authenticationTokenRepository;

    /**
     * @var RequestService
     */
    private $requestService;

    /**
     * @var RequestFactory
     */
    private $requestFactory;

    /**
     * @var ResponseFactory
     */
    private $responseFactory;

    /**
     * @var ResponseService
     */
    private $responseService;

    /**
     * @var array
     */
    private $routes;

    /**
     * @var Router
     */
    private $router;

    /**
     * @var string
     */
    private $version;

    /**
     * api constructor.
     * @param \DI\Container $container
     * @throws \DI\DependencyException
     * @throws \DI\NotFoundException
     */
    public function __construct(Container $container)
    {
        $this->authenticationTokenRepository = $container->get(AuthenticationTokenRepository::class);
        $this->requestFactory = $container->get(RequestFactory::class);
        $this->requestService = $container->get(RequestService::class);
        $this->responseFactory = $container->get(ResponseFactory::class);
        $this->responseService = $container->get(ResponseService::class);
        $this->router = $container->get(Router::class);

        $api = json_decode(FileSystem::readFile(APPLICATION_DIRECTORY . DIRECTORY_SEPARATOR . "src" . DIRECTORY_SEPARATOR . "api.json"), true);
        $this->routes = $api["routes"];
        $this->version = $api["version"];

        try
        {
            $this->run($container);
        }
        catch (MethodNotAllowedException $e) // 405
        {
            $responseBody = [];

            $responseMessage = $e->getMessage();
            $responseData = $e->getData();

            if ($responseMessage)
            {
                $responseBody["message"] = $responseMessage;
            }

            if ($responseData)
            {
                $responseBody["data"] = $responseData;
            }

            $response = $this->responseFactory->create($e->getCode(), [ResponseHeaderEnum::ALLOW => implode(",", $e->getAllowedMethods())], (object) $responseBody);
            $this->responseService->sendResponse($response);
        }
        catch (AbstractHttpClientException $e) // every other >= 400 && < 500 http exception
        {
            $responseBody = [];

            $responseMessage = $e->getMessage();
            $responseData = $e->getData();

            if ($responseMessage)
            {
                $responseBody["message"] = $responseMessage;
            }

            if ($responseData)
            {
                $responseBody["data"] = $responseData;
            }

            $response = $this->responseFactory->create($e->getCode(), [], (object) $responseBody);
            $this->responseService->sendResponse($response);
        }
    }

    /**
     * @return array
     */
    public function getRoutes(): array
    {
        return $this->routes;
    }

    /**
     * @return string
     */
    public function getVersion(): string
    {
        return $this->version;
    }

    /**
     * @param \DI\Container $container
     * @throws \App\Api\Exception\Http\BadRequestException
     * @throws \App\Api\Exception\Http\MethodNotAllowedException
     * @throws \App\Api\Exception\Http\NotFoundException
     * @throws \App\Api\Exception\Http\UnauthorizedException
     * @throws \App\Api\Exception\Http\UnprocessableEntityException
     * @throws \App\Api\Exception\Http\UnsupportedMediaTypeException
     * @throws \DI\DependencyException
     * @throws \DI\NotFoundException
     * @throws \App\Api\Exception\Http\ForbiddenException
     */
    private function run(Container $container): void
    {
        /* Create Request */
        $request = $this->createRequest();

        /* Match route */
        $route = $this->router->match($request, $this->routes);

        /* Handle OPTIONS method */
        if ($request->getMethod() === RequestMethodEnum::OPTIONS && $route[0] === 2)
        {
            $allowedMethods = RequestMethodENum::OPTIONS . "," . implode(",", $route[1]);

            $response = $this->responseFactory->create(ResponseStatusCodeEnum::NO_CONTENT, [
                ResponseHeaderEnum::ACCESS_CONTROL_ALLOW_HEADERS => "*",
                ResponseHeaderEnum::ACCESS_CONTROL_ALLOW_METHODS => $allowedMethods
            ], (object) [
                ResponseHeaderEnum::ALLOW => $allowedMethods
            ]);

            $this->responseService->sendResponse($response);
        }

        /* Validate route */
        $this->validateRoute($route);

        /* Create User */
        $user = $this->createUser($request);

        $routeDefinition = $route[1];

        /* Authorize User */
        $this->authorizeUser($user, $routeDefinition);

        /* Validate request */
        $this->requestService->validateRequest($request, $routeDefinition);

        /* Process Request */
        $response = $this->processRequest($request, $route, $user, $container);

        /* Send Response */
        $this->responseService->sendResponse($response);
    }

    /**
     * @param \App\Api\User\User $user
     * @param array $routeDefinition
     * @throws \App\Api\Exception\Http\ForbiddenException
     */
    private function authorizeUser(User $user, array $routeDefinition): void
    {
        if (!in_array($user->getRole(), $routeDefinition["roles"]))
        {
            throw new ForbiddenException();
        }
    }

    /**
     * @return \App\Api\Request\Request
     */
    private function createRequest(): Request
    {
        $requestBody = Filesystem::readFile("php://input");
        $requestHeaders = getallheaders();
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $requestQuery = urldecode($_SERVER["QUERY_STRING"]);
        $requestUrl = (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] === "on" ? "https" : "http") . "://" . $_SERVER["HTTP_HOST"] . strtok($_SERVER["REQUEST_URI"], "?");

        return $this->requestFactory->create($requestBody, $requestHeaders, $requestMethod, $requestQuery, $requestUrl);
    }

    /**
     * @param \App\Api\Request\Request $request
     * @return \App\Api\User\User
     * @throws \App\Api\Exception\Http\UnauthorizedException
     */
    private function createUser(Request $request): User
    {
        $user = new User();
        $authenticationCode = $request->getHeaders()["Authorization"] ?? null;

        if ($authenticationCode)
        {
            $authenticationToken = $this->authenticationTokenRepository->selectByCode($authenticationCode);

            if ($authenticationToken)
            {
                if ($authenticationToken->getExpiration() < new DateTime("now", new DateTimeZone("UTC"))) // Authentication token expired
                {
                    throw new UnauthorizedException(Translator::__("Authentication token has expired."));
                }

                $account = $authenticationToken->getAccount();
                $user->setAccount($account);
                $user->setAuthenticationToken($authenticationToken);
                $user->setRole($account->getRole());
            }
        }

        return $user;
    }

    /**
     * @param array $route
     * @throws \App\Api\Exception\Http\MethodNotAllowedException
     * @throws \App\Api\Exception\Http\NotFoundException
     */
    private function validateRoute(array $route): void
    {
        $httpStatus = $route[0];

        if ($httpStatus !== 1)
        {
            if ($httpStatus === 0)
            {
                throw new NotFoundException();
            }
            else if ($httpStatus === 2)
            {
                throw new MethodNotAllowedException("", [], [ResponseHeaderEnum::ALLOW => RequestMethodENum::OPTIONS . "," . implode(",", $route[1])]);
            }
        }
    }

    /**
     * @param \App\Api\Request\Request $request
     * @param array $route
     * @param \App\Api\User\User $user
     * @param \DI\Container $container
     * @return \App\Api\Response\Response
     * @throws \DI\DependencyException
     * @throws \DI\NotFoundException
     */
    private function processRequest(Request $request, array $route, User $user, Container $container): Response
    {
        $controller = $route[1]["controller"];
        $action = $route[1]["action"];
        $variables = $route[2];

        /* Create controller */
        $controller = $container->make($controller, [
            "request" => $request,
            "user" => $user
        ]);

        return $container->call([$controller, $action], $variables);
    }
}