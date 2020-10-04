<?php

namespace App\Model\Entity;

use DateTime;
use DateTimeZone;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;

/**
 * @ORM\Entity(repositoryClass="App\Model\Repository\ProductAttributeTextRepository")
 * @ORM\Table(
 *     name="product_attribute_text",
 *     uniqueConstraints={
 *         @ORM\UniqueConstraint(name="product_attribute",columns={"product_id","product_attribute_id"})
 *     }
 * )
 * @ORM\HasLifecycleCallbacks
 */
class ProductAttributeText
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
     * @ORM\OneToMany(targetEntity="ProductAttributeTextTranslatableContent",mappedBy="product_attribute_text",fetch="EXTRA_LAZY",cascade={"persist"},orphanRemoval=true)
     */
    private $translatableContents;

    /**
     * @var Product
     * @ORM\ManyToOne(targetEntity="Product",fetch="EXTRA_LAZY")
     * @ORM\JoinColumn(name="product_id",nullable=false,onDelete="CASCADE")
     */
    private $product;

    /**
     * @var ProductAttribute
     * @ORM\ManyToOne(targetEntity="ProductAttribute",fetch="EXTRA_LAZY")
     * @ORM\JoinColumn(name="product_attribute_id",nullable=false,onDelete="RESTRICT")
     */
    private $productAttribute;

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
     * ProductAttributeInt constructor.
     * @param \App\Model\Entity\Product $product
     * @param \App\Model\Entity\ProductAttribute $productAttribute
     */
    public function __construct(Product $product, ProductAttribute $productAttribute)
    {
        $this->translatableContents = new ArrayCollection();

        $this->setProduct($product);
        $this->setProductAttribute($productAttribute);
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
     * @param ProductAttributeTextTranslatableContent $translatableContent
     */
    public function addTranslatableContent(ProductAttributeTextTranslatableContent $translatableContent): void
    {
        $this->translatableContents->add($translatableContent);
    }

    /**
     * @param ProductAttributeTextTranslatableContent $translatableContent
     * @return bool
     */
    public function removeTranslatableContent(ProductAttributeTextTranslatableContent $translatableContent): bool
    {
        return $this->translatableContents->removeElement($translatableContent);
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