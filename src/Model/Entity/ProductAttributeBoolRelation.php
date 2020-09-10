<?php

namespace App\Model\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="ProductAttributeBoolRelationRepository")
 * @ORM\Table(
 *     name="product_attribute_bool_relation",
 * )
 */
class ProductAttributeBoolRelation
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
     * @var ProductAttributeBool
     * @ORM\ManyToOne(targetEntity="ProductAttributeBool",fetch="LAZY")
     * @ORM\JoinColumn(name="product_attribute_bool_id",referencedColumnName="id",nullable=false)
     */
    private $productAttributeBool;

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
     * @return ProductAttributeBool
     */
    public function getProductAttributeBool(): ProductAttributeBool
    {
        return $this->productAttributeBool;
    }

    /**
     * @param ProductAttributeBool $productAttributeBool
     */
    public function setProductAttributeBool(ProductAttributeBool $productAttributeBool): void
    {
        $this->productAttributeBool = $productAttributeBool;
    }
}