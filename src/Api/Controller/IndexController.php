<?php

namespace App\Api\Controller;

use App\Api\Response\Response;
use App\Model\Entity\Account;
use App\Model\Entity\CategoryTranslatableContent;
use App\Model\Repository\CategoryRepository;
use App\Model\Service\EntityManagerService;
use App\Translator\Translator;

class IndexController extends AbstractController
{
    /**
     * @return \App\Api\Response\Response
     */
    public function read(): Response
    {
        $authenticated = $this->user->isLoggedIn();
        $userData = [
            "authenticated" => $authenticated,
            "role" => $this->user->getRole()
        ];

        if ($authenticated)
        {
            $userData["account"] = [
                "email" => $this->user->getAccount()
                                      ->getEmail(),
                "authenticationTokenExpiration" => $this->user->getAuthenticationToken()
                                                              ->getExpiration()
            ];
        }

        return $this->response((object) $userData);
    }
}