<?php

namespace App\Model\Entity;

use DateTime;
use DateTimeZone;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="PaymentTranslatableContentRepository")
 * @ORM\Table(
 *     name="payment_translatable_content"
 * )
 * @ORM\HasLifecycleCallbacks
 */
class PaymentTranslatableContent
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
    private $summary;

    /**
     * @var string
     * @ORM\Column(type="string",length=10000)
     */
    private $description;

    /**
     * @var Payment
     * @ORM\ManyToOne(targetEntity="Payment",fetch="LAZY")
     * @ORM\JoinColumn(name=payment_id,referencedColumnName="id",nullable="false",onDelete="CASCADE")
     */
    private $payment;

    /**
     * @var Language
     * @ORM\ManyToOne(targetEntity="Language",fetch="LAZY")
     * @ORM\JoinColumn(name=language_id,referencedColumnName="id",nullable="false",onDelete="CASCADE")
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
    public function getSummary(): string
    {
        return $this->summary;
    }

    /**
     * @param string $summary
     */
    public function setSummary(string $summary): void
    {
        $this->summary = $summary;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return Payment
     */
    public function getPayment(): Payment
    {
        return $this->payment;
    }

    /**
     * @param Payment $payment
     */
    public function setPayment(Payment $payment): void
    {
        $this->payment = $payment;
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
     * @param DateTime $created
     */
    public function setCreated(DateTime $created): void
    {
        $this->created = $created;
    }

    /**
     * @return DateTime
     */
    public function getUpdated(): DateTime
    {
        return $this->updated;
    }

    /**
     * @param DateTime $updated
     */
    public function setUpdated(DateTime $updated): void
    {
        $this->updated = $updated;
    }
}