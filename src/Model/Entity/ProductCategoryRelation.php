<?php

namespace App\Model\Entity;

use DateTime;
use DateTimeZone;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Model\Repository\ProductRepository")
 * @ORM\Table(
 *     name="product_category_relation",
 * )
 * @ORM\HasLifecycleCallbacks
 */
class ProductCategoryRelation
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
     * @ORM\ManyToOne(targetEntity="Product",inversedBy="productCategoryRelation",fetch="EXTRA_LAZY")
     * @ORM\JoinColumn(name="product_id",nullable=false,onDelete="CASCADE")
     */
    private $product;

    /**
     * @var Category
     * @ORM\ManyToOne(targetEntity="Category",inversedBy="productCategoryRelation",fetch="EXTRA_LAZY")
     * @ORM\JoinColumn(name="category_id",nullable=false,onDelete="CASCADE")
     */
    private $category;

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
     * ProductCategoryRelation constructor.
     * @param \App\Model\Entity\Product $product
     * @param \App\Model\Entity\Category $category
     */
    public function __construct(Product $product, Category $category)
    {
        $this->setProduct($product);
        $this->setCategory($category);
    }

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
     * @return Category
     */
    public function getCategory(): Category
    {
        return $this->category;
    }

    /**
     * @param Category $category
     */
    public function setCategory(Category $category): void
    {
        $this->category = $category;
    }

    /**
     * @return DateTime
     */
    public function getCreated(): DateTime
    {
        return $this->created;
    }

    /**
     * @return DateTime|null
     */
    public function getUpdated(): ?DateTime
    {
        return $this->updated;
    }
}