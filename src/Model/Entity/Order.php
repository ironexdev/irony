<?php

namespace App\Model\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="OrderRepository")
 * @ORM\Table(
 *     name="order",
 * )
 */
class Order
{
    /**
     * @var string
     * @ORM\Id
     * @ORM\Column(type="guid")
     * @ORM\GeneratedValue(strategy="UUID")
     */
    private $id;

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }
}