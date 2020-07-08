<?php

namespace App\Api\Controller;

use App\Api\Response\Response;
use App\Translator\Translator;

class IndexController extends AbstractController
{
    /**
     * @return \App\Api\Response\Response
     */
    public function read(): Response
    {
        $userData = [
            "role" => $this->user->getRole(),
            "u" => Translator::__("Bad Request")
        ];

        if($this->user->isLoggedIn())
        {
            $userData["email"] = $this->user->getAccount()->getEmail();
            $userData["authentication_token_expiration"] = $this->user->getAuthenticationToken()->getExpiration();
        }

        return $this->response((object) $userData);
    }
}