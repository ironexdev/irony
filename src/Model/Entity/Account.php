<?php

namespace App\Model\Entity;

use App\Enum\AccountRoleEnum;
use DateTime;
use DateTimeZone;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Model\Repository\AccountRepository")
 * @ORM\Table(
 *     name="account",
 *     uniqueConstraints={
 *         @ORM\UniqueConstraint(name="email",columns={"email"})
 *     }
 * )
 * @ORM\HasLifecycleCallbacks
 */
class Account
{
    /**
     * @var string
     * @ORM\Id
     * @ORM\Column(type="guid")
     * @ORM\GeneratedValue(strategy="UUID")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(type="string",length=254)
     */
    private $email;

    /**
     * @var string
     * @ORM\Column(type="string",length=255)
     */
    private $password;

    /**
     * @var string
     * @ORM\Column(name="first_name",type="string",length=255)
     */
    private $firstName;

    /**
     * @var string
     * @ORM\Column(name="last_name",type="string",length=255)
     */
    private $lastName;

    /**
     * @var bool
     * @ORM\Column(name="cookie_consent",type="boolean")
     */
    private $cookieConsent;

    /**
     * @var string
     * @ORM\Column(type="string",columnDefinition="ENUM('member') NOT NULL")
     */
    private $role;

    /**
     * @var Collection
     * @ORM\ManyToMany(targetEntity="Address",fetch="EXTRA_LAZY")
     * @ORM\JoinTable(name="account_address_relation",
     *      joinColumns={@ORM\JoinColumn(name="account_id",referencedColumnName="id",onDelete="cascade")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="addresses_id",referencedColumnName="id",unique=true,onDelete="cascade")}
     * )
     */
    private $addresses;

    /**
     * @var Collection
     * @ORM\OneToMany(targetEntity="AuthenticationToken",mappedBy="account",fetch="EXTRA_LAZY")
     */
    private $authenticationTokens;

    /**
     * @var Collection
     * @ORM\OneToMany(targetEntity="AuthorizationToken",mappedBy="account",fetch="EXTRA_LAZY")
     */
    private $authorizationTokens;

    /**
     * @var Country
     */
    private $country;

    /**
     * @var Language
     * @ORM\ManyToOne(targetEntity="Language",fetch="EXTRA_LAZY")
     * @ORM\JoinColumn(name="language_id",nullable=false,onDelete="CASCADE")
     */
    private $language;

    /**
     * @var DateTime
     * @ORM\Column(type="datetime")
     */
    protected $created;

    /**
     * @var DateTime
     * @ORM\Column(type="datetime",nullable=true)
     */
    protected $updated;

    /**
     * Account constructor.
     * @param string $email
     * @param string $password
     * @param string $firstName
     * @param string $lastName
     * @param bool $cookieConsent
     * @param string $role
     * @param Country $country
     * @param Language $language
     */
    public function __construct(string $email, string $password, string $firstName, string $lastName, bool $cookieConsent = true, string $role = AccountRoleEnum::MEMBER, Country $country, Language $language)
    {
        $this->addresses = new ArrayCollection();

        $this->setEmail($email);
        $this->setPassword($password);
        $this->setFirstName($firstName);
        $this->setLastName($lastName);
        $this->setPassword($password);
        $this->setCookieConsent($cookieConsent);
        $this->setRole($role);
        $this->setCountry($country);
        $this->setLanguage($language);
    }

    /**
     * Gets triggered only on insert
     * @ORM\PrePersist
     */
    public function onPrePersist(): void
    {
        $this->created = new DateTime("now", new DateTimeZone("UTC"));
    }

    /**
     * Gets triggered every time on update
     * @ORM\PreUpdate
     */
    public function onPreUpdate(): void
    {
        $this->updated = new DateTime("now", new DateTimeZone("UTC"));
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName(string $firstName): void
    {
        $this->firstName = $firstName;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     */
    public function setLastName(string $lastName): void
    {
        $this->lastName = $lastName;
    }

    /**
     * @return bool
     */
    public function getCookieConsent(): bool
    {
        return $this->cookieConsent;
    }

    /**
     * @param bool $cookieConsent
     */
    public function setCookieConsent(bool $cookieConsent): void
    {
        $this->cookieConsent = $cookieConsent;
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

    /**
     * @return Collection
     */
    public function getAddresses(): Collection
    {
        return $this->addresses;
    }

    /**
     * @param Address $address
     */
    public function addAddress(Address $address): void
    {
        $this->addresses->add($address);
    }

    /**
     * @param Address $address
     * @return bool
     */
    public function removeAddress(Address $address): bool
    {
        return $this->addresses->removeElement($address);
    }

    /**
     * @return Collection
     */
    public function getAuthenticationTokens(): Collection
    {
        return $this->authenticationTokens;
    }

    /**
     * @return void
     */
    public function removeAuthenticationTokens(): void
    {
        $this->authenticationTokens->clear();
    }

    /**
     * @return Collection
     */
    public function getAuthorizationTokens(): Collection
    {
        return $this->authorizationTokens;
    }

    /**
     * @return void
     */
    public function removeAuthorizationTokens(): void
    {
        $this->authorizationTokens->clear();
    }

    /**
     * @return Country
     */
    public function getCountry(): Country
    {
        return $this->country;
    }

    /**
     * @param Country $country
     */
    public function setCountry(Country $country): void
    {
        $this->country = $country;
    }

    /**
     * @return Language
     */
    public function getLanguage(): Language
    {
        return $this->language;
    }

    /**
     * @param Language $language
     */
    public function setLanguage(Language $language): void
    {
        $this->language = $language;
    }

    /**
     * @return DateTime
     */
    public function getCreated(): DateTime
    {
        return $this->created;
    }

    /**
     * @return DateTime|null
     */
    public function getUpdated(): ?DateTime
    {
        return $this->updated;
    }
}