<?php

namespace App\Model\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="ProductAttributeTextRelationRepository")
 * @ORM\Table(
 *     name="product_attribute_text_relation",
 * )
 */
class ProductAttributeTextRelation
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
     * @var ProductAttributeText
     * @ORM\ManyToOne(targetEntity="ProductAttributeText",fetch="LAZY")
     * @ORM\JoinColumn(name="product_attribute_text_id",referencedColumnName="id",nullable=false)
     */
    private $productAttributeText;

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
     * @return ProductAttributeText
     */
    public function getProductAttributeText(): ProductAttributeText
    {
        return $this->productAttributeText;
    }

    /**
     * @param ProductAttributeText $productAttributeText
     */
    public function setProductAttributeText(ProductAttributeText $productAttributeText): void
    {
        $this->productAttributeText = $productAttributeText;
    }
}