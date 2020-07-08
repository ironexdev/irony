<?php

namespace App\Mailer\Service;

use App\Config\Config;
use App\Mailer\Mailer;
use App\Model\Entity\AuthorizationToken;
use App\Translator\Translator;
use DateTime;
use DateTimeZone;

class MailerService
{
    /**
     * @var Mailer
     */
    private $mailer;

    /**
     * MailerService constructor.
     * @param \App\Mailer\Mailer $mailer
     */
    public function __construct(Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * @param string $to
     * @param \App\Model\Entity\AuthorizationToken $authorizationToken
     */
    public function sendAuthorizationEmail(string $to, AuthorizationToken $authorizationToken): void
    {
        $this->mailer->send([
                                Config::getEmails()["admin"] => Config::getSiteName()
                            ], $to, Translator::__("__x__Authorization__/x__"), Translator::__("__x__Authorization code - {{code}}, it will expire in {{expiration}} minutes.", 1, [
                                 "code" => $authorizationToken->getCode(),
                                 "expiration" => ($authorizationToken->getExpiration()->getTimestamp() - (new DateTime("now", new DateTimeZone("UTC")))->getTimestamp()) / 60
                             ]));
    }
}