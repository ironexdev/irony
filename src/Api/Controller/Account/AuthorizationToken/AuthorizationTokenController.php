<?php

namespace App\Api\Controller\Account\AuthorizationToken;

use App\Api\Controller\AbstractController;
use App\Api\Exception\Http\NotFoundException;
use App\Api\Response\Response;
use App\Enum\ResponseStatusCodeEnum;
use App\Mailer\Service\MailerService;
use App\Model\Entity\Account;
use App\Model\Entity\AuthorizationToken;
use App\Model\Repository\AccountRepository;
use App\Model\Repository\AuthorizationTokenRepository;
use App\Translator\Translator;
use DateTime;
use DateTimeZone;

class AuthorizationTokenController extends AbstractController
{

    /**
     * @param string $accountId
     * @param \App\Model\Repository\AccountRepository $accountRepository
     * @param \App\Model\Repository\AuthorizationTokenRepository $authorizationTokenRepository
     * @param \App\Mailer\Service\MailerService $mailerService
     * @return \App\Api\Response\Response
     * @throws \App\Api\Exception\Http\NotFoundException
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function create(string $accountId, AccountRepository $accountRepository, AuthorizationTokenRepository $authorizationTokenRepository, MailerService $mailerService): Response
    {
        /** @var Account $account */
        $account = $accountRepository->find($accountId);

        if (!$account)
        {
            throw new NotFoundException(Translator::__("__x__Account was not found.__/x__"));
        }

        $authorizationTokenRepository->deleteByAccountId($accountId); // delete all authorization tokens for current account

        $authorizationToken = new AuthorizationToken(new DateTime(AuthorizationToken::TOKEN_DURATION, new DateTimeZone("UTC")), $account);

        $this->entityManagerService->persist($authorizationToken);
        $this->entityManagerService->flush();

        $email = $account->getEmail();

        $mailerService->sendAuthorizationEmail($email, $authorizationToken);

        return $this->response((object) [
            "message" => Translator::__("__x__Authorization code has been sent to {{email}}.__/x__", 1, ["email" => $email])
        ], ResponseStatusCodeEnum::CREATED);
    }
}