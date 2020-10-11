<?php

namespace App\Model\Entity;

use DateTime;
use DateTimeZone;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="PropertyRepository")
 * @ORM\Table(
 *     name="property",
 * )
 * @ORM\HasLifecycleCallbacks
 */
class Property
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
    private $name;

    /**
     * @var string
     * @ORM\Column(type="string",length=255)
     */
    private $addressStreet;

    /**
     * @var string
     * @ORM\Column(type="string",length=255)
     */
    private $addressStreetNumber;

    /**
     * @var string
     * @ORM\Column(type="string",length=255)
     */
    private $addressCity;

    /**
     * @var string
     * @ORM\Column(type="string",length=255)
     */
    private $addressZipCode;

    /**
     * @var string
     * @ORM\Column(type="string",length=255)
     */
    private $addressCountry;

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
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getAddressStreet(): string
    {
        return $this->addressStreet;
    }

    /**
     * @param string $addressStreet
     */
    public function setAddressStreet(string $addressStreet): void
    {
        $this->addressStreet = $addressStreet;
    }

    /**
     * @return string
     */
    public function getAddressStreetNumber(): string
    {
        return $this->addressStreetNumber;
    }

    /**
     * @param string $addressStreetNumber
     */
    public function setAddressStreetNumber(string $addressStreetNumber): void
    {
        $this->addressStreetNumber = $addressStreetNumber;
    }

    /**
     * @return string
     */
    public function getAddressCity(): string
    {
        return $this->addressCity;
    }

    /**
     * @param string $addressCity
     */
    public function setAddressCity(string $addressCity): void
    {
        $this->addressCity = $addressCity;
    }

    /**
     * @return string
     */
    public function getAddressZipCode(): string
    {
        return $this->addressZipCode;
    }

    /**
     * @param string $addressZipCode
     */
    public function setAddressZipCode(string $addressZipCode): void
    {
        $this->addressZipCode = $addressZipCode;
    }

    /**
     * @return string
     */
    public function getAddressCountry(): string
    {
        return $this->addressCountry;
    }

    /**
     * @param string $addressCountry
     */
    public function setAddressCountry(string $addressCountry): void
    {
        $this->addressCountry = $addressCountry;
    }

    /**
     * @return DateTime
     */
    public function getCreated(): DateTime
    {
        return $this->created;
    }

    /**
     * @param DateTime $created
     */
    public function setCreated(DateTime $created): void
    {
        $this->created = $created;
    }

    /**
     * @return DateTime
     */
    public function getUpdated(): DateTime
    {
        return $this->updated;
    }

    /**
     * @param DateTime $updated
     */
    public function setUpdated(DateTime $updated): void
    {
        $this->updated = $updated;
    }
}