<?php

namespace Backup\App\Model\EntityBackup;

use DateTime;
use DateTimeZone;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="OrderRepository")
 * @ORM\Table(
 *     name="order",
 * )
 * @ORM\HasLifecycleCallbacks
 */
class Order
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
    private $phone;

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
     * @var string
     * @ORM\Column(type="string",length=10000)
     */
    private $note;

    /**
     * @var string
     * @ORM\Column(type="string",columnDefinition="ENUM('CZK,EUR') NOT NULL")
     */
    private $currency;

    /**
     * @var string
     * @ORM\Column(type="decimal")
     */
    private $price;

    /**
     * @var string
     * @ORM\Column(type="decimal")
     */
    private $tax;

    /**
     * @var string
     * @ORM\Column(type="decimal")
     */
    private $deliveryPrice;

    /**
     * @var string
     * @ORM\Column(type="decimal")
     */
    private $deliveryTax;

    /**
     * @var string
     * @ORM\Column(type="decimal")
     */
    private $paymentPrice;

    /**
     * @var string
     * @ORM\Column(type="decimal")
     */
    private $paymentTax;

    /**
     * @var string
     * @ORM\Column(type="string",columnDefinition="ENUM('new,expedited,delivered,paid,cancelled') NOT NULL")
     */
    private $status;

    /**
     * @var Account
     * @ORM\ManyToOne(targetEntity="Account",fetch="LAZY")
     * @ORM\JoinColumn(name="account_id",nullable=true,onDelete="RESTRICT")
     */
    private $account;

    /**
     * @var Address
     * @ORM\ManyToOne(targetEntity="Address",fetch="LAZY")
     * @ORM\JoinColumn(name="address_id",nullable=true,onDelete="RESTRICT")
     */
    private $address;

    /**
     * @var Delivery
     * @ORM\ManyToOne(targetEntity="Delivery",fetch="LAZY")
     * @ORM\JoinColumn(name="delivery_id",nullable=true,onDelete="RESTRICT")
     */
    private $delivery;

    /**
     * @var Language
     * @ORM\ManyToOne(targetEntity="Language",fetch="LAZY")
     * @ORM\JoinColumn(name="language_id",onDelete="RESTRICT")
     */
    private $language;

    /**
     * @var Country
     * @ORM\ManyToOne(targetEntity="Country",fetch="LAZY")
     * @ORM\JoinColumn(name="country_id",onDelete="RESTRICT")
     */
    private $country;

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
    public function getPhone(): string
    {
        return $this->phone;
    }

    /**
     * @param string $phone
     */
    public function setPhone(string $phone): void
    {
        $this->phone = $phone;
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
     * @return string
     */
    public function getNote(): string
    {
        return $this->note;
    }

    /**
     * @param string $note
     */
    public function setNote(string $note): void
    {
        $this->note = $note;
    }

    /**
     * @return string
     */
    public function getCurrency(): string
    {
        return $this->currency;
    }

    /**
     * @param string $currency
     */
    public function setCurrency(string $currency): void
    {
        $this->currency = $currency;
    }

    /**
     * @return string
     */
    public function getPrice(): string
    {
        return $this->price;
    }

    /**
     * @param string $price
     */
    public function setPrice(string $price): void
    {
        $this->price = $price;
    }

    /**
     * @return string
     */
    public function getTax(): string
    {
        return $this->tax;
    }

    /**
     * @param string $tax
     */
    public function setTax(string $tax): void
    {
        $this->tax = $tax;
    }

    /**
     * @return string|null
     */
    public function getDeliveryPrice(): ?string
    {
        return $this->deliveryPrice;
    }

    /**
     * @param string $deliveryPrice
     */
    public function setDeliveryPrice(string $deliveryPrice): void
    {
        $this->deliveryPrice = $deliveryPrice;
    }

    /**
     * @return string|null
     */
    public function getDeliveryTax(): ?string
    {
        return $this->deliveryTax;
    }

    /**
     * @param string $deliveryTax
     */
    public function setDeliveryTax(string $deliveryTax): void
    {
        $this->deliveryTax = $deliveryTax;
    }

    /**
     * @return string|null
     */
    public function getPaymentPrice(): ?string
    {
        return $this->paymentPrice;
    }

    /**
     * @param string $paymentPrice
     */
    public function setPaymentPrice(string $paymentPrice): void
    {
        $this->paymentPrice = $paymentPrice;
    }

    /**
     * @return string|null
     */
    public function getPaymentTax(): ?string
    {
        return $this->paymentTax;
    }

    /**
     * @param string $paymentTax
     */
    public function setPaymentTax(string $paymentTax): void
    {
        $this->paymentTax = $paymentTax;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    /**
     * @return Account|null
     */
    public function getAccount(): ?Account
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
     * @return Address|null
     */
    public function getAddress(): ?Address
    {
        return $this->address;
    }

    /**
     * @param Address $address
     */
    public function setAddress(Address $address): void
    {
        $this->address = $address;
    }

    /**
     * @return Delivery|null
     */
    public function getDelivery(): ?Delivery
    {
        return $this->delivery;
    }

    /**
     * @param Delivery $delivery
     */
    public function setDelivery(Delivery $delivery): void
    {
        $this->delivery = $delivery;
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