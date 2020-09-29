<?php

namespace App\Model\Entity;

use DateTime;
use DateTimeZone;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;

/**
 * @ORM\Entity(repositoryClass="App\Model\Repository\CategoryRepository")
 * @ORM\Table(
 *     name="category"
 * )
 * @ORM\HasLifecycleCallbacks
 */
class Category
{
    /**
     * @var string
     * @ORM\Id
     * @ORM\Column(type="guid")
     * @ORM\GeneratedValue(strategy="UUID")
     */
    private $id;

    /**
     * @var Category
     * @ORM\ManyToOne(targetEntity="Category",fetch="EXTRA_LAZY")
     * @ORM\JoinColumn(name="parent_id",onDelete="SET NULL")
     */
    private $parent;

    /**
     * @var Collection
     * @ORM\OneToMany(targetEntity="CategoryTranslatableContent",mappedBy="category",fetch="EXTRA_LAZY")
     */
    private $translatableContent;

    /**
     * @var Collection
     * @ORM\ManyToMany(targetEntity="Product",inversedBy="product",fetch="EXTRA_LAZY")
     * @ORM\JoinColumn(name="product_id")
     */
    private $products;

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
     * Category constructor.
     */
    public function __construct()
    {
        $this->translatableContent = new ArrayCollection();
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
     * @return Category
     */
    public function getParent(): Category
    {
        return $this->parent;
    }

    /**
     * @param Category $parent
     */
    public function setParent(Category $parent): void
    {
        $this->parent = $parent;
    }

    /**
     * @param Language $language
     * @return PersistentCollection
     */
    public function getTranslatableContent(Language $language): Collection
    {
        return $this->translatableContent->matching(Criteria::create()->where(Criteria::expr()->eq("language_id", $language->getId())))[0];
    }

    /**
     * @param Collection $translatableContent
     */
    public function setTranslatableContent(Collection $translatableContent): void
    {
        $this->translatableContent = $translatableContent;
    }

    /**
     * @return Collection
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    /**
     * @param Product $product
     */
    public function addProduct(Product $product): void
    {
        $this->products->add($product);
    }

    /**
     * @param Product $product
     * @return bool
     */
    public function removeProduct(Product $product): bool
    {
        return $this->products->removeElement($product);
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