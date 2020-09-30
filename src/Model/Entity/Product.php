<?php

namespace App\Model\Entity;

use DateTime;
use DateTimeZone;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;

/**
 * @ORM\Entity(repositoryClass="App\Model\Repository\ProductRepository")
 * @ORM\Table(
 *     name="product",
 * )
 * @ORM\HasLifecycleCallbacks
 */
class Product
{
    /**
     * @var string
     * @ORM\Id
     * @ORM\Column(type="guid")
     * @ORM\GeneratedValue(strategy="UUID")
     */
    private $id;

    /**
     * @var Collection
     * @ORM\OneToMany(targetEntity="ProductCategoryRelation",mappedBy="product",fetch="EXTRA_LAZY",cascade={"persist"},orphanRemoval=true)
     */
    private $productCategoryRelations;

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
     * Product constructor.
     */
    public function __construct()
    {
        $this->productCategoryRelations = new ArrayCollection();
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
     * @return Collection
     */
    public function getProductCategoryRelations(): Collection
    {
        return $this->productCategoryRelations;
    }

    /**
     * @return Collection
     */
    public function getCategories(): Collection
    {
        $categories = new ArrayCollection();

        /** @var ProductCategoryRelation $productCategoryRelation */
        foreach($this->productCategoryRelations as $productCategoryRelation)
        {
            $categories->add($productCategoryRelation->getCategory());
        }

        return $categories;
    }

    /**
     * @param Category $category
     */
    public function addCategory(Category $category)
    {
        $this->productCategoryRelations->add(new ProductCategoryRelation($this, $category));
    }

    /**
     * @param ProductCategoryRelation $productCategoryRelation
     * @return bool
     */
    public function removeCategory(ProductCategoryRelation $productCategoryRelation): bool
    {
        return $this->productCategoryRelations->removeElement($productCategoryRelation);
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