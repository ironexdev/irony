<?php

namespace App\Model\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="ProductRelatedRelationRepository")
 * @ORM\Table(
 *     name="product_related_relation",
 * )
 */
class ProductRelatedRelation
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
     * @ORM\JoinColumn(name="related_product_id",referencedColumnName="id",nullable=false)
     */
    private $relatedProduct;

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
    public function getRelatedProduct(): Product
    {
        return $this->relatedProduct;
    }

    /**
     * @param Product $relatedProduct
     */
    public function setRelatedProduct(Product $relatedProduct): void
    {
        $this->relatedProduct = $relatedProduct;
    }
}