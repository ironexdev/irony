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
     * @ORM\OneToMany(targetEntity="CategoryCountryContent",mappedBy="category",fetch="EXTRA_LAZY",cascade={"persist"},orphanRemoval=true)
     */
    private $countryContents;

    /**
     * @var Collection
     * @ORM\OneToMany(targetEntity="CategoryTranslatableContent",mappedBy="category",fetch="EXTRA_LAZY",cascade={"persist"},orphanRemoval=true)
     */
    private $translatableContents;

    /**
     * @var Collection
     * @ORM\OneToMany(targetEntity="ProductCategoryRelation",mappedBy="category",fetch="EXTRA_LAZY",cascade={"persist"},orphanRemoval=true)
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
     * Category constructor.
     * @param \App\Model\Entity\Category|null $parent
     */
    public function __construct(?Category $parent = null)
    {
        $this->countryContents = new ArrayCollection();
        $this->productCategoryRelations = new ArrayCollection();
        $this->translatableContents = new ArrayCollection();

        if($parent)
        {
            $this->setParent($parent);
        }
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
     * @return Category|null
     */
    public function getParent(): ?Category
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
    public function getCountryContent(Language $language): Collection
    {
        return $this->countryContents->matching(Criteria::create()->where(Criteria::expr()->eq("language_id", $language->getId())))[0];
    }

    /**
     * @return PersistentCollection
     */
    public function getCountryContents(): Collection
    {
        return $this->countryContents;
    }

    /**
     * @param CategoryCountryContent $countryContent
     */
    public function addCountryContent(CategoryCountryContent $countryContent): void
    {
        $this->countryContents->add($countryContent);
    }

    /**
     * @param CategoryCountryContent $countryContent
     * @return bool
     */
    public function removeCountryContent(CategoryCountryContent $countryContent): bool
    {
        return $this->countryContents->removeElement($countryContent);
    }

    /**
     * @param Language $language
     * @return Collection
     */
    public function getTranslatableContent(Language $language): Collection
    {
        return $this->translatableContents->matching(Criteria::create()->where(Criteria::expr()->eq("language_id", $language->getId())))[0];
    }

    /**
     * @return PersistentCollection
     */
    public function getTranslatableContents(): Collection
    {
        return $this->translatableContents;
    }

    /**
     * @param CategoryTranslatableContent $translatableContent
     */
    public function addTranslatableContent(CategoryTranslatableContent $translatableContent): void
    {
        $this->translatableContents->add($translatableContent);
    }

    /**
     * @param CategoryTranslatableContent $translatableContent
     * @return bool
     */
    public function removeTranslatableContent(CategoryTranslatableContent $translatableContent): bool
    {
        return $this->translatableContents->removeElement($translatableContent);
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
    public function getProducts(): Collection
    {
        $products = new ArrayCollection();

        /** @var ProductCategoryRelation $productCategoryRelation */
        foreach($this->productCategoryRelations as $productCategoryRelation)
        {
            $products->add($productCategoryRelation->getProduct());
        }

        return $products;
    }

    /**
     * @param Product $product
     */
    public function addProduct(Product $product)
    {
        $this->productCategoryRelations->add(new ProductCategoryRelation($product, $this));
    }

    /**
     * @param ProductCategoryRelation $productCategoryRelation
     * @return bool
     */
    public function removeProduct(ProductcategoryRelation $productCategoryRelation): bool
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