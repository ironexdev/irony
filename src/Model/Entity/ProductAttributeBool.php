<?php

namespace App\Model\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="ProductAttributeBoolRepository")
 * @ORM\Table(
 *     name="product_attribute_bool",
 * )
 */
class ProductAttributeBool
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
    private $value;

    /**
     * @var ProductAttribute
     * @ORM\ManyToOne(targetEntity="ProductAttribute",fetch="LAZY")
     * @ORM\JoinColumn(name="product_attribute_id",referencedColumnName="id",nullable=false)
     */
    private $productAttribute;

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
    public function getValue(): bool
    {
        return $this->value;
    }

    /**
     * @param bool $value
     */
    public function setValue(bool $value): void
    {
        $this->value = $value;
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
}