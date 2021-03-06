<?php

namespace App\Model\Entity;

use DateTime;
use DateTimeZone;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Model\Repository\AddressRepository")
 * @ORM\Table(
 *     name="address",
 *     uniqueConstraints={
 *         @ORM\UniqueConstraint(name="address",columns={"street","street_number","city","country"})
 *     }
 * )
 * @ORM\HasLifecycleCallbacks
 */
class Address
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
    private $street;

    /**
     * @var string
     * @ORM\Column(name="street_number",type="string",length=255)
     */
    private $streetNumber;

    /**
     * @var string
     * @ORM\Column(type="string",length=255)
     */
    private $city;

    /**
     * @var string
     * @ORM\Column(name="zip_code",type="string",length=255)
     */
    private $zipCode;

    /**
     * @var string
     * @ORM\Column(type="string",length=255)
     */
    private $country;

    /**
     * @var string
     * @ORM\Column(type="text",length=10000)
     */
    private $note;

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
     * Address constructor.
     * @param string $street
     * @param string $streetNumber
     * @param string $city
     * @param string $zipCode
     * @param string $country
     * @param string|null $note
     */
    public function __construct(string $street, string $streetNumber, string $city, string $zipCode, string $country, string $note = null)
    {
        $this->setStreet($street);
        $this->setStreetNumber($streetNumber);
        $this->setCity($city);
        $this->setZipCode($zipCode);
        $this->setCountry($country);
        $this->setNote($note);
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
    public function getStreet(): string
    {
        return $this->street;
    }

    /**
     * @param string $street
     */
    public function setStreet(string $street): void
    {
        $this->street = $street;
    }

    /**
     * @return string
     */
    public function getStreetNumber(): string
    {
        return $this->streetNumber;
    }

    /**
     * @param string $streetNumber
     */
    public function setStreetNumber(string $streetNumber): void
    {
        $this->streetNumber = $streetNumber;
    }

    /**
     * @return string
     */
    public function getCity(): string
    {
        return $this->city;
    }

    /**
     * @param string $city
     */
    public function setCity(string $city): void
    {
        $this->city = $city;
    }

    /**
     * @return string
     */
    public function getZipCode(): string
    {
        return $this->zipCode;
    }

    /**
     * @param string $zipCode
     */
    public function setZipCode(string $zipCode): void
    {
        $this->zipCode = $zipCode;
    }

    /**
     * @return string
     */
    public function getCountry(): string
    {
        return $this->country;
    }

    /**
     * @param string $country
     */
    public function setCountry(string $country): void
    {
        $this->country = $country;
    }

    public function __toString(): string
    {
        return $this->street;
    }

    /**
     * @return string|null
     */
    public function getNote(): ?string
    {
        return $this->note;
    }

    /**
     * @param null|string $note
     */
    public function setNote(?string $note): void
    {
        $this->note = $note;
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