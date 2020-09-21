<?php

namespace App\Model\Entity;

use DateTime;
use DateTimeZone;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="AccountRepository")
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
     * @ORM\Column(type="string",length=255)
     */
    private $email;

    /**
     * @var string
     * @ORM\Column(type="string",length=255)
     */
    private $password;

    /**
     * @var string
     * @ORM\Column(type="string",length=255)
     */
    private $firstName;

    /**
     * @var string
     * @ORM\Column(type="string",length=255)
     */
    private $lastName;

    /**
     * @var bool
     * @ORM\Column(type="boolean")
     */
    private $cookieConsent;

    /**
     * @var string
     * @ORM\Column(type="string",columnDefinition="ENUM('member') NOT NULL")
     */
    private $role;

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
     * @param string $role
     */
    public function __construct(string $email, string $password, string $role)
    {
        $this->setEmail($email);
        $this->setPassword($password);
        $this->setRole($role);
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
    public function isCookieConsent(): bool
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
     * @return DateTime
     */
    public function getCreated(): DateTime
    {
        return $this->created;
    }

    /**
     * @return DateTime
     */
    public function getUpdated(): DateTime
    {
        return $this->updated;
    }
}