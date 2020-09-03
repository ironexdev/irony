<?php

namespace App\Model\Fixture;

use App\Enum\AccountRoleEnum;
use App\Model\Entity\Account;
use App\Security\Service\CryptService;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Persistence\ObjectManager;

class AccountFixture extends AbstractFixture
{
    /**
     * @var \App\Security\Service\CryptService
     */
    private $cryptService;

    /**
     * AccountFixtures constructor.
     * @param \App\Security\Service\CryptService $cryptService
     */
    public function __construct(CryptService $cryptService)
    {
        $this->cryptService = $cryptService;
    }

    /**
     * @param \Doctrine\Persistence\ObjectManager $manager
     */
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 10; $i++)
        {
            $email = "address" . $i . "@domain.com";
            $password = $this->cryptService->hash("test1234");
            $role = AccountRoleEnum::MEMBER;

            $account = new Account($email, $password, $role);

            $manager->persist($account);
        }

        $manager->flush();
    }
}