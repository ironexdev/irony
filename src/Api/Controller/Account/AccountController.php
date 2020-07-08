<?php

namespace App\Api\Controller\Account;

use App\Api\Controller\AbstractController;
use App\Api\Exception\Http\ConflictException;
use App\Api\Exception\Http\ForbiddenException;
use App\Api\Exception\Http\NotFoundException;
use App\Api\Response\Response;
use App\Enum\AccountRoleEnum;
use App\Enum\ResponseStatusCodeEnum;
use App\Model\Entity\Account;
use App\Model\Repository\AccountRepository;
use App\Model\Repository\AuthorizationTokenRepository;
use App\Security\Service\CryptService;
use App\Translator\Translator;
use DateTime;
use DateTimeZone;

class AccountController extends AbstractController
{
    /**
     * @param \App\Model\Repository\AccountRepository $accountRepository
     * @param \App\Security\Service\CryptService $cryptService
     * @return \App\Api\Response\Response
     * @throws \App\Api\Exception\Http\ConflictException
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function create(AccountRepository $accountRepository, CryptService $cryptService): Response
    {
        $email = $this->request->getBody()->email;

        if ($accountRepository->selectByEmail($email))
        {
            throw new ConflictException("", [
                "email" => Translator::__("__x__Account with this e-mail already exists.__/x__")
            ]);
        }

        $password = $this->request->getBody()->password;

        $account = new Account($email, $cryptService->hash($password), AccountRoleEnum::MEMBER);

        $this->entityManagerService->persist($account);
        $this->entityManagerService->flush();

        return $this->response((object) [], ResponseStatusCodeEnum::CREATED);
    }

    /**
     * @param string $id
     * @param \App\Model\Repository\AccountRepository $accountRepository
     * @param \App\Model\Repository\AuthorizationTokenRepository $authorizationTokenRepository
     * @param \App\Security\Service\CryptService $cryptService
     * @return \App\Api\Response\Response
     * @throws \App\Api\Exception\Http\ForbiddenException
     * @throws \App\Api\Exception\Http\NotFoundException
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function update(string $id, AccountRepository $accountRepository, AuthorizationTokenRepository $authorizationTokenRepository, CryptService $cryptService): Response
    {
        $authorizationCode = $this->request->getBody()->authorizationCode;

        $account = $accountRepository->find($id);

        if(!$account)
        {
            throw new NotFoundException(Translator::__("Account does not exist."));
        }

        $authorizationToken = $authorizationTokenRepository->selectByCode($authorizationCode);

        if (!$authorizationToken)
        {
            throw new ForbiddenException("", ["authorization_code" => Translator::__("Authorization code does not exist.")]);
        }

        $authorizationTokenAccountId = $authorizationToken->getAccount()->getId();

        if($account->getId() !== $authorizationTokenAccountId)
        {
            throw new ForbiddenException("", ["authorization_code" => Translator::__("Authorization code does not match the account.")]);
        }

        if ($authorizationToken->getExpiration() < new DateTime("now", new DateTimeZone("UTC"))) // authorization token expired
        {
            throw new ForbiddenException("", ["authorization_code" => Translator::__("Authorization code has expired.")]);
        }

        $updatedProperties = 0;
        $password = $this->request->getBody()->password ?? null;

        if($password && $password !== $account->getPassword())
        {
            $account->setPassword($cryptService->hash($password));
            $updatedProperties++;
        }

        $authorizationTokenRepository->deleteByAccountId($account->getId()); // delete all authorization tokens for current account

        if($updatedProperties)
        {
            $this->entityManagerService->persist($account);
            $this->entityManagerService->flush();
        }

        return $this->response((object) [], ResponseStatusCodeEnum::OK);
    }
}