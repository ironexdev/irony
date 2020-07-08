<?php

namespace App\Api\Controller\Account\AuthenticationToken;

use App\Api\Controller\AbstractController;
use App\Api\Exception\Http\NotFoundException;
use App\Api\Exception\Http\UnprocessableEntityException;
use App\Api\Response\Response;
use App\Enum\ResponseStatusCodeEnum;
use App\Model\Entity\Account;
use App\Model\Entity\AuthenticationToken;
use App\Model\Repository\AccountRepository;
use App\Security\Service\CryptService;
use App\Translator\Translator;
use DateTime;
use DateTimeZone;

class AuthenticationTokenController extends AbstractController
{
    /**
     * @param string $accountId
     * @param \App\Model\Repository\AccountRepository $accountRepository
     * @param \App\Security\Service\CryptService $cryptService
     * @return \App\Api\Response\Response
     * @throws \App\Api\Exception\Http\NotFoundException
     * @throws \App\Api\Exception\Http\UnprocessableEntityException
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function create(string $accountId, AccountRepository $accountRepository, CryptService $cryptService): Response
    {
        $password = $this->request->getBody()->password;

        /** @var Account $account */
        $account = $accountRepository->find($accountId);

        if(!$account)
        {
            throw new NotFoundException(Translator::__("__x__Account was not found.__/x__"));
        }

        if(!$cryptService->verify($password, $account->getPassword()))
        {
            throw new UnprocessableEntityException("", ["password" => Translator::__("__x__Invalid password.__/x__")]);
        }

        $authenticationToken = new AuthenticationToken(uniqid(time(), true), new DateTime(AuthenticationToken::TOKEN_DURATION, new DateTimeZone("UTC")), $account);

        $this->entityManagerService->persist($authenticationToken);
        $this->entityManagerService->flush();

        return $this->response((object) [
            "token" => $authenticationToken->getCode()
        ], ResponseStatusCodeEnum::CREATED);
    }
}