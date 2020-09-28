<?php

namespace App\Api\Controller;

use App\Api\Response\Response;
use App\Model\Entity\CategoryTranslatableContent;
use App\Model\Repository\CategoryRepository;
use App\Translator\Translator;

class IndexController extends AbstractController
{
    /**
     * @param \App\Model\Repository\CategoryRepository $categoryRepository
     * @return \App\Api\Response\Response
     */
    public function read(CategoryRepository $categoryRepository): Response
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

        var_dump(get_class($categoryRepository->findByTitle("Mobile Phones")->getTranslatableContent())); exit;

        return $this->response((object) $category);
    }
}