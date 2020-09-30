<?php

namespace App\Api\Controller;

use App\Api\Exception\Http\BadRequestException;
use App\Api\User\User;
use App\Enum\RequestHeaderEnum;
use App\Enum\ResponseStatusCodeEnum;
use App\Api\Request\Request;
use App\Api\Response\Response;
use App\Api\Response\ResponseFactory;
use App\Model\Entity\Country;
use App\Model\Entity\Language;
use App\Model\Repository\CountryRepository;
use App\Model\Repository\LanguageRepository;
use App\Model\Service\EntityManagerService;
use App\Translator\Translator;

abstract class AbstractController
{
    /**
     * @var Country
     */
    protected $country;

    /**
     * @var EntityManagerService
     */
    protected $entityManagerService;

    /**
     * @var Language
     */
    protected $language;
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
     * @param \App\Model\Repository\CountryRepository $countryRepository
     * @param \App\Model\Repository\LanguageRepository $languageRepository
     * @throws \App\Api\Exception\Http\BadRequestException
     */
    public function __construct(EntityManagerService $entityManagerService, Request $request, ResponseFactory $responseFactory, User $user, CountryRepository $countryRepository, LanguageRepository $languageRepository)
    {
        $this->entityManagerService = $entityManagerService;
        $this->request = $request;
        $this->responseFactory = $responseFactory;
        $this->user = $user;

        $headers = $request->getHeaders();

        /* Set Country */
        $this->setCountry($countryRepository, $headers);

        /* Set Language */
        $this->setLanguage($languageRepository, $headers);
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

    /**
     * @param \App\Model\Repository\CountryRepository $countryRepository
     * @param $headers
     * @throws \App\Api\Exception\Http\BadRequestException
     */
    private function setCountry(CountryRepository $countryRepository, $headers): void
    {
        $countryHeader = $headers[RequestHeaderEnum::X_COUNTRY] ?? null;
        $country = $countryHeader ? $countryRepository->findOneBy(["iso2" => $countryHeader]) : null;

        if (!$country)
        {
            throw new BadRequestException(Translator::__("__x__Supported country ISO2 code has to be specified in X-Country request header.__/x__"));
        }

        $this->country = $country;
    }

    /**
     * @param \App\Model\Repository\LanguageRepository $languageRepository
     * @param $headers
     * @throws \App\Api\Exception\Http\BadRequestException
     */
    private function setLanguage(LanguageRepository $languageRepository, $headers): void
    {
        /* Set Language */
        $languageHeader = $headers[RequestHeaderEnum::ACCEPT_LANGUAGE] ?? null;
        $language = $languageHeader ? $languageRepository->findOneBy(["iso2" => $languageHeader]) : null;

        if (!$language)
        {
            throw new BadRequestException(Translator::__("__x__Supported language ISO2 code has to be specified in Accept-Language request header.__/x__"));
        }

        $this->language = $language;
    }
}