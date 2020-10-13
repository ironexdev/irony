<?php

namespace App\Model\Entity;

use DateTime;
use DateTimeZone;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="ReviewRepository")
 * @ORM\Table(
 *     name="review"
 * )
 * @ORM\HasLifecycleCallbacks
 */
class Review
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
    private $email;

    /**
     * @var string
     * @ORM\Column(type="string",length=255)
     */
    private $firstName;

    /**
     * @var string
     * @ORM\Column(type="string",length=255)
     */
    private $lastName;

    /**
     * @var string
     * @ORM\Column(type="string",length=255)
     */
    private $city;

    /**
     * @var string
     * @ORM\Column(type="string",length=255)
     */
    private $country;

    /**
     * @var integer
     * @ORM\Column(type="integer")
     */
    private $like;

    /**
     * @var integer
     * @ORM\Column(type="integer")
     */
    private $dislike;

    /**
     * @var string
     * @ORM\Column(type="string",length=10000)
     */
    private $content;

    /**
     * @var string
     * @ORM\Column(type="string",length=10000)
     */
    private $pros;

    /**
     * @var string
     * @ORM\Column(type="string",length=10000)
     */
    private $cons;

    /**
     * @var string
     * @ORM\Column(type="string",columnDefinition="ENUM('waiting','approved','disapproved') NOT NULL")
     */
    private $status;

    /**
     * @var Account
     * @ORM\ManyToOne(targetEntity="Account",fetch="LAZY")
     * @ORM\JoinColumn(name="account_id",nullable=true,onDelete="RESTRICT")
     */
    private $account;

    /**
     * @var Language
     * @ORM\ManyToOne(targetEntity="Language",fetch="LAZY")
     * @ORM\JoinColumn(name="language_id",onDelete="RESTRICT")
     */
    private $language;

    /**
     * @var Product
     * @ORM\ManyToOne(targetEntity="Product",fetch="EXTRA_LAZY")
     * @ORM\JoinColumn(name="product_id",nullable=false,onDelete="CASCADE")
     */
    private $product;

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
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName(string $firstName): void
    {
        $this->firstName = $firstName;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     */
    public function setLastName(string $lastName): void
    {
        $this->lastName = $lastName;
    }

    /**
     * @return string
     */
    public function getCity(): string
    {
        return $this->city;
    }

    /**
     * @param string $city
     */
    public function setCity(string $city): void
    {
        $this->city = $city;
    }

    /**
     * @return string
     */
    public function getCountry(): string
    {
        return $this->country;
    }

    /**
     * @param string $country
     */
    public function setCountry(string $country): void
    {
        $this->country = $country;
    }

    /**
     * @return int
     */
    public function getLike(): int
    {
        return $this->like;
    }

    /**
     * @param int $like
     */
    public function setLike(int $like): void
    {
        $this->like = $like;
    }

    /**
     * @return int
     */
    public function getDislike(): int
    {
        return $this->dislike;
    }

    /**
     * @param int $dislike
     */
    public function setDislike(int $dislike): void
    {
        $this->dislike = $dislike;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @param string $content
     */
    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    /**
     * @return string
     */
    public function getPros(): string
    {
        return $this->pros;
    }

    /**
     * @param string $pros
     */
    public function setPros(string $pros): void
    {
        $this->pros = $pros;
    }

    /**
     * @return string
     */
    public function getCons(): string
    {
        return $this->cons;
    }

    /**
     * @param string $cons
     */
    public function setCons(string $cons): void
    {
        $this->cons = $cons;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    /**
     * @return Account|null
     */
    public function getAccount(): ?Account
    {
        return $this->account;
    }

    /**
     * @param Account $account
     */
    public function setAccount(Account $account): void
    {
        $this->account = $account;
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