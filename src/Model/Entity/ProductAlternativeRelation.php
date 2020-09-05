<?php

namespace App\Model\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="ProductAlternativeRelationRepository")
 * @ORM\Table(
 *     name="product_alternative_relation",
 * )
 */
class ProductAlternativeRelation
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
     * @ORM\JoinColumn(name="alternative_product_id",referencedColumnName="id",nullable=false)
     */
    private $alternativeProduct;

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
    public function getAlternativeProduct(): Product
    {
        return $this->alternativeProduct;
    }

    /**
     * @param Product $alternativeProduct
     */
    public function setAlternativeProduct(Product $alternativeProduct): void
    {
        $this->alternativeProduct = $alternativeProduct;
    }
}