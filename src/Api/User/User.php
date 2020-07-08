<?php

namespace App\Api\User;

use App\Enum\UserRoleEnum;
use App\Model\Entity\Account;
use App\Model\Entity\AuthenticationToken;

class User
{
    /**
     * @var Account
     */
    private $account;

    /**
     * @var AuthenticationToken
     */
    private $authenticationToken;

    /**
     * @var String
     */
    private $role = UserRoleEnum::VISITOR;

    /**
     * @return bool
     */
    public function isLoggedIn(): bool
    {
        return $this->account ? true : false;
    }

    /**
     * @return Account
     */
    public function getAccount(): Account
    {
        return $this->account;
    }

    /**
     * @param Account $account
     */
    public function setAccount(Account $account): void
    {
        $this->account = $account;
    }

    /**
     * @return \App\Model\Entity\AuthenticationToken
     */
    public function getAuthenticationToken(): AuthenticationToken
    {
        return $this->authenticationToken;
    }

    /**
     * @param AuthenticationToken $authenticationToken
     */
    public function setAuthenticationToken(AuthenticationToken $authenticationToken): void
    {
        $this->authenticationToken = $authenticationToken;
    }

    /**
     * @return string
     */
    public function getRole(): string
    {
        return $this->role;
    }

    /**
     * @param string $role
     */
    public function setRole(string $role): void
    {
        $this->role = $role;
    }
}