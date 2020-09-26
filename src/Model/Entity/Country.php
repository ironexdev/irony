<?php

namespace App\Model\Entity;

use DateTime;
use DateTimeZone;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="CountryRepository")
 * @ORM\Table(
 *     name="country",
 * )
 * @ORM\HasLifecycleCallbacks
 */
class Country
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
     * @ORM\Column(type="string",length=2)
     */
    private $iso2;

    /**
     * @var string
     * @ORM\Column(type="string",length=3)
     */
    private $currencyIso3;

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
    public function getIso2(): string
    {
        return $this->iso2;
    }

    /**
     * @param string $iso2
     */
    public function setIso2(string $iso2): void
    {
        $this->iso2 = $iso2;
    }

    /**
     * @return string
     */
    public function getCurrencyIso3(): string
    {
        return $this->currencyIso3;
    }

    /**
     * @param string $currencyIso3
     */
    public function setCurrencyIso3(string $currencyIso3): void
    {
        $this->currencyIso3 = $currencyIso3;
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