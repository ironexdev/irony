<?php

namespace App\Model\Entity;

use DateTime;
use DateTimeZone;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

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
     * @var string
     * @ORM\Column(type="decimal")
     */
    private $price;

    /**
     * @var Category
     * @ORM\ManyToOne(targetEntity="Category",fetch="EXTRA_LAZY")
     * @ORM\JoinColumn(name="parent_category_id")
     */
     private $parentCategory;

    /**
     * @var Collection
     * @ORM\ManyToMany(targetEntity="Category",inversedBy="category",fetch="EXTRA_LAZY")
     * @ORM\JoinColumn(name="category_id")
     */
     private $categories;

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
        $this->categories = new ArrayCollection();
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
     * @return string
     */
    public function getPrice(): string
    {
        return $this->price;
    }

    /**
     * @param string $price
     */
    public function setPrice(string $price): void
    {
        $this->price = $price;
    }

    /**
     * @return Category
     */
    public function getParentCategory(): Category
    {
        return $this->parentCategory;
    }

    /**
     * @param Category $parentCategory
     */
    public function setParentCategory(Category $parentCategory): void
    {
        $this->parentCategory = $parentCategory;
    }

    /**
     * @return Collection
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    /**
     * @param Category $category
     * @return void
     */
    public function addCategory(Category $category): void
    {
        $this->categories->add($category);
    }

    /**
     * @param Category $category
     * @return bool
     */
    public function removeCategory(Category $category): bool
    {
        return $this->categories->removeElement($category);
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