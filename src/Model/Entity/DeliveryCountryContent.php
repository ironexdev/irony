<?php

namespace App\Model\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="DeliveryRepository")
 * @ORM\Table(
 *     name="delivery_country_content",
 * )
 */
class DeliveryCountryContent
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
     * @ORM\Column(type="decimal")
     */
    private $price;

    /**
     * @var string
     * @ORM\Column(type="decimal")
     */
    private $tax;

    /**
     * @var Delivery
     * @ORM\ManyToOne(targetEntity="Delivery",fetch="LAZY")
     * @ORM\JoinColumn(name=delivery_id,referencedColumnName="id",nullable="false",onDelete="CASCADE")
     */
    private $delivery;

    /**
     * @var Country
     * @ORM\ManyToOne(targetEntity="Country",fetch="LAZY")
     * @ORM\JoinColumn(name=country_id,referencedColumnName="id",nullable="false",onDelete="CASCADE")
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
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
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
     * @return Delivery
     */
    public function getDelivery(): Delivery
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
     * @return \DateTime
     */
    public function getCreated(): \DateTime
    {
        return $this->created;
    }

    /**
     * @return \DateTime
     */
    public function getUpdated(): \DateTime
    {
        return $this->updated;
    }
}