<?php

namespace App\Model\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="ProductAttributeIntRelationRepository")
 * @ORM\Table(
 *     name="product_attribute_int_relation",
 * )
 */
class ProductAttributeIntRelation
{
    /**
     * @var string
     * @ORM\Id
     * @ORM\Column(type="guid")
     * @ORM\GeneratedValue(strategy="UUID")
     */
    private $id;

    /**
     * @var Product
     * @ORM\ManyToOne(targetEntity="Product",fetch="LAZY")
     * @ORM\JoinColumn(name="product_id",referencedColumnName="id",nullable=false)
     */
    private $product;

    /**
     * @var ProductAttribute
     * @ORM\ManyToOne(targetEntity="ProductAttribute",fetch="LAZY")
     * @ORM\JoinColumn(name="product_attribute_id",referencedColumnName="id",nullable=false)
     */
    private $productAttribute;

    /**
     * @var ProductAttributeInt
     * @ORM\ManyToOne(targetEntity="ProductAttributeInt",fetch="LAZY")
     * @ORM\JoinColumn(name="product_attribute_int_id",referencedColumnName="id",nullable=false)
     */
    private $productAttributeInt;

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
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
     * @return ProductAttributeInt
     */
    public function getProductAttributeInt(): ProductAttributeInt
    {
        return $this->productAttributeInt;
    }

    /**
     * @param ProductAttributeInt $productAttributeInt
     */
    public function setProductAttributeInt(ProductAttributeInt $productAttributeInt): void
    {
        $this->productAttributeInt = $productAttributeInt;
    }
}