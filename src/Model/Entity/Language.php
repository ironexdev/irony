<?php

namespace App\Model\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="LanguageRepository")
 * @ORM\Table(
 *     name="language",
 * )
 */
class Language
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
    private $iso2;

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
    public function getIso2(): string
    {
        return $this->iso2;
    }

    /**
     * @param string $iso2
     */
    public function setIso2(string $iso2): void
    {
        $this->iso2 = $iso2;
    }
}