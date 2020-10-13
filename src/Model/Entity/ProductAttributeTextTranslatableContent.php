<?php

namespace App\Model\Entity;

use DateTime;
use DateTimeZone;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Model\Repository\ProductAttributeTextTranslatableContentRepository")
 * @ORM\Table(
 *     name="product_attribute_text_translatable_content",
 *     uniqueConstraints={
 *         @ORM\UniqueConstraint(name="product_attribute_text_language",columns={"product_attribute_text_id","language_id"})
 *     }
 * )
 * @ORM\HasLifecycleCallbacks
 */
class ProductAttributeTextTranslatableContent
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
    private $value;

    /**
     * @var ProductAttributeText
     * @ORM\ManyToOne(targetEntity="ProductAttributeText",fetch="EXTRA_LAZY",inversedBy="translatableContents")
     * @ORM\JoinColumn(name="product_attribute_text_id",nullable=false,onDelete="CASCADE")
     */
    private $productAttributeText;

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
     * ProductAttributeInt constructor.
     * @param string $value
     * @param \App\Model\Entity\ProductAttributeText $productAttributeText
     * @param \App\Model\Entity\Language $language
     */
    public function __construct(string $value, ProductAttributeText $productAttributeText, Language $language)
    {
        $this->setValue($value);
        $this->setProductAttributeText($productAttributeText);
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
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @param string $value
     */
    public function setValue(string $value): void
    {
        $this->value = $value;
    }

    /**
     * @return ProductAttributeText
     */
    public function getProductAttributeText(): ProductAttributeText
    {
        return $this->productAttributeText;
    }

    /**
     * @param ProductAttributeText $productAttributeText
     */
    public function setProductAttributeText(ProductAttributeText $productAttributeText): void
    {
        $this->productAttributeText = $productAttributeText;
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