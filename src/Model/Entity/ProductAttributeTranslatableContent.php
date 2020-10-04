<?php

namespace App\Model\Entity;

use DateTime;
use DateTimeZone;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Model\Repository\ProductAttributeTranslatableContentRepository")
 * @ORM\Table(
 *     name="product_attribute_translatable_content",
 *     uniqueConstraints={
 *         @ORM\UniqueConstraint(name="title_language",columns={"title","language_id"}),
 *         @ORM\UniqueConstraint(name="product_attribute_language",columns={"product_attribute_id","language_id"})
 *     }
 * )
 * @ORM\HasLifecycleCallbacks
 */
class ProductAttributeTranslatableContent
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
     * @ORM\Column(type="string",length=255)
     */
    private $title;

    /**
     * @var string
     * @ORM\Column(type="string",length=255)
     */
    private $units;

    /**
     * @var ProductAttribute
     * @ORM\ManyToOne(targetEntity="ProductAttribute",fetch="EXTRA_LAZY",inversedBy="translatable_contents")
     * @ORM\JoinColumn(name="product_attribute_id",nullable=false,onDelete="CASCADE")
     */
    private $productAttribute;

    /**
     * @var Language
     * @ORM\ManyToOne(targetEntity="Language",fetch="EXTRA_LAZY")
     * @ORM\JoinColumn(name="language_id",nullable=false)
     */
    private $language;

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
     * ProductAttributeTranslatableContent constructor.
     * @param string $title
     * @param string $units
     * @param \App\Model\Entity\ProductAttribute $productAttribute
     * @param \App\Model\Entity\Language $language
     */
    public function __construct(string $title, string $units, ProductAttribute $productAttribute, Language $language)
    {
        $this->setTitle($title);
        $this->setUnits($units);
        $this->setProductAttribute($productAttribute);
        $this->setLanguage($language);
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
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getUnits(): string
    {
        return $this->units;
    }

    /**
     * @param string $units
     */
    public function setUnits(string $units): void
    {
        $this->units = $units;
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
     * @return Language
     */
    public function getLanguage(): Language
    {
        return $this->language;
    }

    /**
     * @param Language $language
     */
    public function setLanguage(Language $language): void
    {
        $this->language = $language;
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