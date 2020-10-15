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
 * @ORM\Entity(repositoryClass="App\Model\Repository\DeliveryRepository")
 * @ORM\Table(
 *     name="delivery",
 * )
 * @ORM\HasLifecycleCallbacks
 */
class Delivery
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
    private $code;

    /**
     * @var Collection
     * @ORM\OneToMany(targetEntity="DeliveryCountryContent",mappedBy="delivery",fetch="EXTRA_LAZY",cascade={"persist"},orphanRemoval=true)
     */
    private $countryContents;

    /**
     * @var Collection
     * @ORM\OneToMany(targetEntity="DeliveryTranslatableContent",mappedBy="delivery",fetch="EXTRA_LAZY",cascade={"persist"},orphanRemoval=true)
     */
    private $translatableContents;

    /**
     * @var string
     * @ORM\Column(type="string",length=255)
     */
    private $type;

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

    public function __construct()
    {
        $this->countryContents = new ArrayCollection();
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
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @param string $code
     */
    public function setCode(string $code): void
    {
        $this->code = $code;
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
     * @param DeliveryCountryContent $countryContent
     */
    public function addCountryContent(DeliveryCountryContent $countryContent): void
    {
        $this->countryContents->add($countryContent);
    }

    /**
     * @param DeliveryCountryContent $countryContent
     * @return bool
     */
    public function removeCountryContent(DeliveryCountryContent $countryContent): bool
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
     * @param DeliveryTranslatableContent $translatableContent
     */
    public function addTranslatableContent(DeliveryTranslatableContent $translatableContent): void
    {
        $this->translatableContents->add($translatableContent);
    }

    /**
     * @param DeliveryTranslatableContent $translatableContent
     * @return bool
     */
    public function removeTranslatableContent(DeliveryTranslatableContent $translatableContent): bool
    {
        return $this->translatableContents->removeElement($translatableContent);
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
     * @return DateTime
     */
    public function getCreated(): DateTime
    {
        return $this->created;
    }

    /**
     * @return DateTime
     */
    public function getUpdated(): DateTime
    {
        return $this->updated;
    }
}