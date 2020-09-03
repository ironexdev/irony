<?php

namespace App\Model\Entity;

use DateTime;
use DateTimeZone;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="AuthorizationTokenRepository")
 * @ORM\Table(
 *     name="authorization_token"
 * )
 * @ORM\HasLifecycleCallbacks
 */
class AuthorizationToken
{
    const TOKEN_DURATION = "1 hour";

    /**
     * @ORM\Id
     * @ORM\Column(type="guid")
     * @ORM\GeneratedValue(strategy="UUID")
     */
    private $id;

    /**
     * @ORM\Column(type="string",length=255,nullable=false)
     */
    private $code;

    /**
     * @ORM\Column(type="datetime",nullable=false)
     */
    private $expiration;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $created;

    /**
     * @ORM\Column(type="datetime",nullable=true)
     */
    protected $updated;

    /**
     * @ORM\ManyToOne(targetEntity="Account",fetch="LAZY")
     * @ORM\JoinColumn(name="account_id",referencedColumnName="id",nullable=false,onDelete="CASCADE")
     */
    private $account;

    /**
     * AuthorizationToken constructor.
     * @param string $code
     * @param \DateTime $expiration
     * @param \App\Model\Entity\Account $account
     */
    public function __construct(string $code, DateTime $expiration, Account $account)
    {
        $this->code = $code;
        $this->expiration = $expiration;
        $this->account = $account;
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
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @param string $code
     */
    public function setCode(string $code): void
    {
        $this->code = $code;
    }

    /**
     * @return DateTime
     */
    public function getExpiration(): DateTime
    {
        return $this->expiration;
    }

    /**
     * @param DateTime $expiration
     */
    public function setExpiration(DateTime $expiration): void
    {
        $this->expiration = $expiration;
    }

    /**
     * @return Account
     */
    public function getAccount(): Account
    {
        return $this->account;
    }

    /**
     * @param account $account
     */
    public function setAccount(Account $account): void
    {
        $this->account = $account;
    }
}