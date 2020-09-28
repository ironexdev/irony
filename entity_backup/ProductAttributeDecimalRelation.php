<?php

namespace Backup\App\Model\Entity;

use DateTime;
use DateTimeZone;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="ProductAttributeDecimalRelationRepository")
 * @ORM\Table(
 *     name="product_attribute_decimal_relation",
 * )
 * @ORM\HasLifecycleCallbacks
 */
class ProductAttributeDecimalRelation
{
    /**
     * @var string
     * @ORM\Id
     * @ORM\Column(type="guid")
     * @ORM\GeneratedValue(strategy="UUID")
     */
    private $id;

    /**
     * @var bool
     * @ORM\Column(type="boolean")
     */
    private $highlighted;

    /**
     * @var Product
     * @ORM\ManyToOne(targetEntity="Product",fetch="LAZY")
     * @ORM\JoinColumn(name="product_id")
     */
    private $product;

    /**
     * @var ProductAttribute
     * @ORM\ManyToOne(targetEntity="ProductAttribute",fetch="LAZY")
     * @ORM\JoinColumn(name="product_attribute_id")
     */
    private $productAttribute;

    /**
     * @var ProductAttributeDecimal
     * @ORM\ManyToOne(targetEntity="ProductAttributeDecimal",fetch="LAZY")
     * @ORM\JoinColumn(name="product_attribute_decimal_id")
     */
    private $productAttributeDecimal;

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
     * @return bool
     */
    public function getHighlighted(): bool
    {
        return $this->highlighted;
    }

    /**
     * @param bool $highlighted
     */
    public function setHighlighted(bool $highlighted): void
    {
        $this->highlighted = $highlighted;
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
     * @return ProductAttribute
     */
    public function getProductAttribute(): ProductAttribute
    {
        return $this->productAttribute;
    }

    /**
     * @param ProductAttribute $productAttribute
     */
    public function setProductAttribute(ProductAttribute $productAttribute): void
    {
        $this->productAttribute = $productAttribute;
    }

    /**
     * @return ProductAttributeDecimal
     */
    public function getProductAttributeDecimal(): ProductAttributeDecimal
    {
        return $this->productAttributeDecimal;
    }

    /**
     * @param ProductAttributeDecimal $productAttributeDecimal
     */
    public function setProductAttributeDecimal(ProductAttributeDecimal $productAttributeDecimal): void
    {
        $this->productAttributeDecimal = $productAttributeDecimal;
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