<?php

namespace App\Model\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="CategoryContentRepository")
 * @ORM\Table(
 *     name="category_content",
 *     uniqueConstraints={
 *         @ORM\UniqueConstraint(name="title",columns={"title","language_id"})
 *     }
 * )
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
     * @ORM\ManyToOne(targetEntity="Product",fetch="LAZY")
     * @ORM\JoinColumn(name="language_id",referencedColumnName="id",nullable=false,onDelete="RESTRICT")
     */
    private $language;

    /**
     * @var Category
     * @ORM\ManyToOne(targetEntity="Category",fetch="LAZY")
     * @ORM\JoinColumn(name="category_id",referencedColumnName="id",nullable=false,onDelete="CASCADE")
     */
    private $category;

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
}