<?php

namespace App\Model\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="ProductVariantRelationRepository")
 * @ORM\Table(
 *     name="product_variant_relation",
 * )
 */
class ProductVariantRelation
{
    /**
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
     * @var Product
     * @ORM\ManyToOne(targetEntity="Product",fetch="LAZY")
     * @ORM\JoinColumn(name="product_variant_id",referencedColumnName="id",nullable=false)
     */
    private $productVariant;

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
     * @return Product
     */
    public function getProductVariant(): Product
    {
        return $this->productVariant;
    }

    /**
     * @param Product $productVariant
     */
    public function setProductVariant(Product $productVariant): void
    {
        $this->productVariant = $productVariant;
    }
}