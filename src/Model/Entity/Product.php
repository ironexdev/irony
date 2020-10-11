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
     * @ORM\OneToMany(targetEntity="ProductCountryContent",mappedBy="product",fetch="EXTRA_LAZY",cascade={"persist"},orphanRemoval=true)
     */
    private $countryContents;

    /**
     * @var Collection
     * @ORM\OneToMany(targetEntity="ProductTranslatableContent",mappedBy="product",fetch="EXTRA_LAZY",cascade={"persist"},orphanRemoval=true)
     */
    private $translatableContents;

    /**
     * @var Collection
     * @ORM\OneToMany(targetEntity="ProductAttributeRelation",mappedBy="product",fetch="EXTRA_LAZY",cascade={"persist"},orphanRemoval=true)
     */
    private $productAttributeRelations;

    /**
     * @var Collection
     * @ORM\OneToMany(targetEntity="ProductCategoryRelation",mappedBy="product",fetch="EXTRA_LAZY",cascade={"persist"},orphanRemoval=true)
     */
    private $productCategoryRelations;

    /**
     * @ORM\ManyToMany(targetEntity="Product")
     * @ORM\JoinTable(name="product_alternative_relation",
     *     joinColumns={@ORM\JoinColumn(name="product_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="product_alternative_id", referencedColumnName="id")}
     * )
     * @var Collection
     */
    private $alternatives;

    /**
     * @ORM\ManyToMany(targetEntity="Product")
     * @ORM\JoinTable(name="product_accessory_relation",
     *     joinColumns={@ORM\JoinColumn(name="product_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="product_accessory_id", referencedColumnName="id")}
     * )
     * @var Collection
     */
    private $accessories;

    /**
     * @ORM\ManyToMany(targetEntity="Product")
     * @ORM\JoinTable(name="product_variant_relation",
     *     joinColumns={@ORM\JoinColumn(name="product_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="product_variant_id", referencedColumnName="id")}
     * )
     * @var Collection
     */
    private $variants;

    /**
     * @var Warranty
     * @ORM\OneToOne(targetEntity="Warranty",inversedBy="cart")
     * @ORM\JoinColumn(name="warranty_id",nullable=true,referencedColumnName="id")
     */
    private $warranty;

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
        $this->alternatives = new ArrayCollection();
        $this->productAttributeRelations = new ArrayCollection();
        $this->countryContents = new ArrayCollection();
        $this->productCategoryRelations = new ArrayCollection();
        $this->translatableContents = new ArrayCollection();
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
     * @param ProductCountryContent $countryContent
     */
    public function addCountryContent(ProductCountryContent $countryContent): void
    {
        $this->countryContents->add($countryContent);
    }

    /**
     * @param ProductCountryContent $countryContent
     * @return bool
     */
    public function removeCountryContent(ProductCountryContent $countryContent): bool
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
     * @param ProductTranslatableContent $translatableContent
     */
    public function addTranslatableContent(ProductTranslatableContent $translatableContent): void
    {
        $this->translatableContents->add($translatableContent);
    }

    /**
     * @param ProductTranslatableContent $translatableContent
     * @return bool
     */
    public function removeTranslatableContent(ProductTranslatableContent $translatableContent): bool
    {
        return $this->translatableContents->removeElement($translatableContent);
    }

    /**
     * @return Collection
     */
    public function getProductAttributeRelations(): Collection
    {
        return $this->productAttributeRelations;
    }

    /**
     * @return Collection
     */
    public function getAttributes(): Collection
    {
        $attributes = new ArrayCollection();

        /** @var ProductAttributeRelation $productAttributeRelation */
        foreach($this->productAttributeRelations as $productAttributeRelation)
        {
            $attributes->add($productAttributeRelation->getProductAttribute());
        }

        return $attributes;
    }

    /**
     * @param ProductAttribute $attribute
     */
    public function addAttribute(ProductAttribute $attribute): void
    {
        $this->productAttributeRelations->add(new ProductAttributeRelation($this, $attribute));
    }

    /**
     * @param array $attributes
     */
    public function addAttributes(array $attributes): void
    {
        foreach($attributes as $attribute)
        {
            $this->productAttributeRelations->add(new ProductAttributeRelation($this, $attribute));
        }
    }

    /**
     * @param ProductAttributeRelation $productAttributeRelation
     * @return bool
     */
    public function removeAttribute(ProductAttributeRelation $productAttributeRelation): bool
    {
        return $this->productAttributeRelations->removeElement($productAttributeRelation);
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
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAlternatives(): Collection
    {
        return $this->alternatives;
    }

    /**
     * @param \App\Model\Entity\Product $alternative
     * @return void
     */
    public function addAlternative(Product $alternative)
    {
        if (!$this->alternatives->contains($alternative)) {
            $this->alternatives->add($alternative);
            $alternative->addAlternative($this);
        }
    }

    /**
     * @param \App\Model\Entity\Product $alternative
     * @return void
     */
    public function removeAlternative(Product $alternative)
    {
        if ($this->alternatives->contains($alternative)) {
            $this->alternatives->removeElement($alternative);
            $alternative->removeAlternative($this);
        }
    }

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAccessories(): Collection
    {
        return $this->accessories;
    }

    public function addAccessory(Product $accessory)
    {
        $this->accessories->add($accessory);
    }

    public function removeAccessory(Product $accessory)
    {
        $this->accessories->removeElement($accessory);
    }

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getVariants(): Collection
    {
        return $this->variants;
    }

    /**
     * @param \App\Model\Entity\Product $variant
     * @return void
     */
    public function addVariant(Product $variant)
    {
        if (!$this->variants->contains($variant)) {
            $this->variants->add($variant);
            $variant->addVariant($this);
        }
    }

    /**
     * @param \App\Model\Entity\Product $variant
     * @return void
     */
    public function removeVariant(Product $variant)
    {
        if ($this->variants->contains($variant)) {
            $this->variants->removeElement($variant);
            $variant->removeVariant($this);
        }
    }

    /**
     * @return Warranty|null
     */
    public function getWarranty(): ?Warranty
    {
        return $this->warranty;
    }

    /**
     * @param Warranty $warranty
     */
    public function setWarranty(Warranty $warranty): void
    {
        $this->warranty = $warranty;
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