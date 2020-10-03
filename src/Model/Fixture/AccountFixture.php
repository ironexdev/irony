<?php

namespace App\Model\Fixture;

use App\Enum\AccountRoleEnum;
use App\Enum\CountryEnum;
use App\Enum\LanguageEnum;
use App\Model\Entity\Account;
use App\Model\Entity\Country;
use App\Model\Entity\Language;
use App\Model\Repository\CountryRepository;
use App\Model\Repository\LanguageRepository;
use App\Security\Service\CryptService;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Persistence\ObjectManager;

class AccountFixture extends AbstractFixture
{
    /**
     * @var CountryRepository
     */
    private $countryRepository;

    /**
     * @var \App\Security\Service\CryptService
     */
    private $cryptService;

    /**
     * @var LanguageRepository
     */
    private $languageRepository;

    /**
     * AccountFixtures constructor.
     * @param \App\Security\Service\CryptService $cryptService
     * @param \App\Model\Repository\CountryRepository $countryRepository
     * @param \App\Model\Repository\LanguageRepository $languageRepository
     */
    public function __construct(CryptService $cryptService, CountryRepository $countryRepository, LanguageRepository $languageRepository)
    {
        $this->cryptService = $cryptService;
        $this->countryRepository = $countryRepository;
        $this->languageRepository = $languageRepository;
    }

    /**
     * @param \Doctrine\Persistence\ObjectManager $manager
     */
    public function load(ObjectManager $manager): void
    {
        /** @var Language $enLanguage */
        $enLanguage = $this->languageRepository->findOneBy(["iso2" => LanguageEnum::EN]);
        /** @var Language $csLanguage */
        $csLanguage = $this->languageRepository->findOneBy(["iso2" => LanguageEnum::CS]);

        /** @var Country $usCountry */
        $usCountry = $this->countryRepository->findOneBy(["iso2" => CountryEnum::US]);
        /** @var Country $czCountry */
        $czCountry = $this->countryRepository->findOneBy(["iso2" => CountryEnum::CZ]);

        for ($i = 0; $i < 10000; $i++)
        {
            $email = "address" . $i . "@domain.com";
            $password = $this->cryptService->hash("test1234");
            $role = AccountRoleEnum::MEMBER;
            $firstName = "FirstName" . $i;
            $lastName = "LastName" . $i;
            $country = $i % 2 ? $usCountry : $czCountry;
            $language = $i % 2 ? $enLanguage : $csLanguage;
            $account = new Account($email, $password, $firstName, $lastName, (bool) $i % 2, $role, $country, $language);

            $manager->persist($account);
        }

        $manager->flush();
    }

    /**
     * @return array
     */
    public function getDependencies(): array
    {
        return [
            CountryFixture::class,
            LanguageFixture::class
        ];
    }
}