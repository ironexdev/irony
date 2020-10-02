<?php

namespace App\Model\Entity;

use DateTime;
use DateTimeZone;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="ProductCountryContentRepository")
 * @ORM\Table(
 *     name="product_country_content",
 *     uniqueConstraints={
 *         @ORM\UniqueConstraint(name="product_country",columns={"product_id","country_id"})
 *     }
 * )
 * @ORM\HasLifecycleCallbacks
 */
class ProductCountryContent
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
     * @var string
     * @ORM\Column(type="decimal")
     */
    private $discount;

    /**
     * @var string
     * @ORM\Column(type="string",columnDefinition="ENUM('CZK,EUR') NOT NULL")
     */
    private $currency;

    /**
     * @var bool
     * @ORM\Column(type="boolean")
     */
    private $top;

    /**
     * @var Product
     * @ORM\ManyToOne(targetEntity="Product",inversedBy="countryContents",fetch="EXTRA_LAZY")
     * @ORM\JoinColumn(name="product_id",nullable=false,onDelete="CASCADE")
     */
    private $product;

    /**
     * @var Country
     * @ORM\ManyToOne(targetEntity="Country",fetch="EXTRA_LAZY")
     * @ORM\JoinColumn(name="country_id",nullable=false)
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
     * @return string
     */
    public function getDiscount(): string
    {
        return $this->discount;
    }

    /**
     * @param string $discount
     */
    public function setDiscount(string $discount): void
    {
        $this->discount = $discount;
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
     * @return bool
     */
    public function isTop(): bool
    {
        return $this->top;
    }

    /**
     * @param bool $top
     */
    public function setTop(bool $top): void
    {
        $this->top = $top;
    }

    /**
     * @return Product
     */
    public function getProduct(): Product
    {
        return $this->product;
    }

    /**
     * @param Product $product
     */
    public function setProduct(Product $product): void
    {
        $this->product = $product;
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
}