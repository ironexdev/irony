<?php

namespace App\Model\Entity;

use DateTime;
use DateTimeZone;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="StockRepository")
 * @ORM\Table(
 *     name="stock"
 * )
 * @ORM\HasLifecycleCallbacks
 */
class Stock
{
    /**
     * @var string
     * @ORM\Id
     * @ORM\Column(type="guid")
     * @ORM\GeneratedValue(strategy="UUID")
     */
    private $id;

    /**
     * @var int
     * @ORM\Column(type="integer",nullable=false)
     */
    private $count;

    /**
     * @var Property
     * @ORM\ManyToOne(targetEntity="Property",fetch="LAZY")
     * @ORM\JoinColumn(name="property_id",referencedColumnName="id",nullable=false)
     */
    private $property;

    /**
     * @var Product
     * @ORM\ManyToOne(targetEntity="Product",fetch="LAZY")
     * @ORM\JoinColumn(name="product_id",referencedColumnName="id",nullable=false)
     */
    private $product;

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
     * @return int
     */
    public function getCount(): int
    {
        return $this->count;
    }

    /**
     * @param int $count
     */
    public function setCount(int $count): void
    {
        $this->count = $count;
    }

    /**
     * @return \App\Model\Entity\Property
     */
    public function getProperty(): \App\Model\Entity\Property
    {
        return $this->property;
    }

    /**
     * @param \App\Model\Entity\Property $property
     */
    public function setProperty(\App\Model\Entity\Property $property): void
    {
        $this->property = $property;
    }

    /**
     * @return \App\Model\Entity\Product
     */
    public function getProduct(): \App\Model\Entity\Product
    {
        return $this->product;
    }

    /**
     * @param \App\Model\Entity\Product $product
     */
    public function setProduct(\App\Model\Entity\Product $product): void
    {
        $this->product = $product;
    }

    /**
     * @return \App\Model\Entity\Country
     */
    public function getCountry(): \App\Model\Entity\Country
    {
        return $this->country;
    }

    /**
     * @param \App\Model\Entity\Country $country
     */
    public function setCountry(\App\Model\Entity\Country $country): void
    {
        $this->country = $country;
    }
}