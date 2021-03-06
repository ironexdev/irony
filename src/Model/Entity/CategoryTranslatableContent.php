<?php

namespace App\Model\Entity;

use DateTime;
use DateTimeZone;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Model\Repository\CategoryTranslatableContentRepository")
 * @ORM\Table(
 *     name="category_translatable_content",
 *     uniqueConstraints={
 *         @ORM\UniqueConstraint(name="title_language",columns={"title","language_id"}),
 *         @ORM\UniqueConstraint(name="category_language",columns={"category_id","language_id"})
 *     }
 * )
 * @ORM\HasLifecycleCallbacks
 */
class CategoryTranslatableContent
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
     * @var Language
     * @ORM\ManyToOne(targetEntity="Language",fetch="EXTRA_LAZY")
     * @ORM\JoinColumn(name="language_id",nullable=false)
     */
    private $language;

    /**
     * @var Category
     * @ORM\ManyToOne(targetEntity="Category",inversedBy="translatableContents",fetch="EXTRA_LAZY")
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
     * CategoryTranslatableContent constructor.
     * @param string $title
     * @param \App\Model\Entity\Category $category
     * @param \App\Model\Entity\Language $language
     */
    public function __construct(string $title, Category $category, Language $language)
    {
        $this->setTitle($title);
        $this->setCategory($category);
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