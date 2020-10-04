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
 * @ORM\Entity(repositoryClass="App\Model\Repository\ProductAttributeRepository")
 * @ORM\Table(
 *     name="product_attribute",
 * )
 * @ORM\HasLifecycleCallbacks
 */
class ProductAttribute
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
     * @ORM\Column(type="string",columnDefinition="ENUM('boolean','decimal','int','text') NOT NULL")
     */
    private $type;

    /**
     * @var Collection
     * @ORM\OneToMany(targetEntity="ProductAttributeTranslatableContent",mappedBy="product_attribute",fetch="EXTRA_LAZY",cascade={"persist"},orphanRemoval=true)
     */
    private $translatableContents;

    /**
     * @var Collection
     * @ORM\OneToMany(targetEntity="ProductAttributeRelation",mappedBy="product_attribute",fetch="EXTRA_LAZY",cascade={"persist"},orphanRemoval=true)
     */
    private $productAttributeRelations;

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
     * ProductAttribute constructor.
     * @param string $type
     */
    public function __construct(string $type)
    {
        $this->productAttributeRelations = new ArrayCollection();
        $this->translatableContents = new ArrayCollection();

        $this->setType($type);
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
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type): void
    {
        $this->type = $type;
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
     * @param ProductAttributeTranslatableContent $translatableContent
     */
    public function addTranslatableContent(ProductAttributeTranslatableContent $translatableContent): void
    {
        $this->translatableContents->add($translatableContent);
    }

    /**
     * @param ProductAttributeTranslatableContent $translatableContent
     * @return bool
     */
    public function removeTranslatableContent(ProductAttributeTranslatableContent $translatableContent): bool
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
    public function getProducts(): Collection
    {
        $products = new ArrayCollection();

        /** @var ProductAttributeRelation $productAttributeRelation */
        foreach($this->productAttributeRelations as $productAttributeRelation)
        {
            $products->add($productAttributeRelation->getProduct());
        }

        return $products;
    }

    /**
     * @param \App\Model\Entity\Product $product
     */
    public function addProduct(Product $product)
    {
        $this->productAttributeRelations->add(new ProductAttributeRelation($product, $this));
    }

    /**
     * @param \App\Model\Entity\ProductAttributeRelation $productAttributeRelation
     * @return bool
     */
    public function removeProduct(ProductAttributeRelation $productAttributeRelation): bool
    {
        return $this->productAttributeRelations->removeElement($productAttributeRelation);
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