<?php

namespace App\Model\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="ProductAttributeDecimalRepository")
 * @ORM\Table(
 *     name="product_attribute_decimal",
 * )
 */
class ProductAttributeDecimal
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
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @param string $value
     */
    public function setValue(string $value): void
    {
        $this->value = $value;
    }

    /**
     * @return \App\Model\Entity\ProductAttribute
     */
    public function getProductAttribute(): \App\Model\Entity\ProductAttribute
    {
        return $this->productAttribute;
    }

    /**
     * @param \App\Model\Entity\ProductAttribute $productAttribute
     */
    public function setProductAttribute(\App\Model\Entity\ProductAttribute $productAttribute): void
    {
        $this->productAttribute = $productAttribute;
    }
}