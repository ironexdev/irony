<?php

namespace App\Model\Fixture;

use App\Enum\AccountRoleEnum;
use App\Enum\CountryEnum;
use App\Enum\LanguageEnum;
use App\Model\Entity\Account;
use App\Model\Entity\Address;
use App\Model\Entity\Country;
use App\Model\Entity\Language;
use App\Model\Repository\AccountFactory;
use App\Model\Repository\AddressRepository;
use App\Model\Repository\CountryRepository;
use App\Model\Repository\LanguageRepository;
use App\Security\Service\CryptService;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class AccountFixture extends AbstractFixture implements DependentFixtureInterface
{
    /**
     * @var AccountFactory
     */
    private $accountFactory;

    /**
     * @var AddressRepository
     */
    private $addressRepository;

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
     * @param \App\Model\Repository\AccountFactory $accountFactory
     * @param \App\Model\Repository\AddressRepository $addressRepository
     * @param \App\Security\Service\CryptService $cryptService
     * @param \App\Model\Repository\CountryRepository $countryRepository
     * @param \App\Model\Repository\LanguageRepository $languageRepository
     */
    public function __construct(AccountFactory $accountFactory, AddressRepository $addressRepository, CryptService $cryptService, CountryRepository $countryRepository, LanguageRepository $languageRepository)
    {
        $this->accountFactory = $accountFactory;
        $this->addressRepository = $addressRepository;
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

        /** @var Address[] $addresses */
        $addresses = $this->addressRepository->findAll();

        for ($i = 0; $i < 10000; $i++)
        {
            $email = "address" . $i . "@domain.com";
            $password = "$2y$10$4KCRQ3WSTsUFDfNzugEnEu0v7Gz/e7EBaCrj.he7d0/G6B3QNWLbu"; // test1234 -> faster than $this->cryptService->hash("test1234"), but can cause problems when the algorithm changes
            $role = AccountRoleEnum::MEMBER;
            $firstName = "FirstName" . $i;
            $lastName = "LastName" . $i;
            $country = $i % 2 ? $usCountry : $czCountry;
            $language = $i % 2 ? $enLanguage : $csLanguage;
            $account = $this->accountFactory->create($email, $password, $firstName, $lastName, (bool) $i % 2, $role, $country, $language);
            $account->addAddress($addresses[$i]);
            $account->addAddress($addresses[$i + 1] ?? $addresses[0]);

            $manager->persist($account);
        }

        $manager->flush();
        $manager->clear();

        echo static::class . " done.\n";
    }

    /**
     * @return array
     */
    public function getDependencies(): array
    {
        return [
            AddressFixture::class,
            CountryFixture::class,
            LanguageFixture::class
        ];
    }
}