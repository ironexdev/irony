<?php

namespace App\Model\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="EntityRepository")
 * @ORM\Table(
 *     name="entity",
 * )
 */
class Entity
{
    /**
     * @var string
     * @ORM\Id
     * @ORM\Column(type="guid")
     * @ORM\GeneratedValue(strategy="UUID")
     */
    private $id;

    /**
     * @var Todo
     * @ORM\ManyToOne(targetEntity="Todo",fetch="LAZY")
     * @ORM\JoinColumn(name="todo_id",referencedColumnName="id",nullable=false)
     */
     private $todo;

    /**
     * @var string
     * @ORM\Column(type="string",length=255)
     */
    private $todo2;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $created;

    /**
     * @ORM\Column(type="datetime",nullable=true)
     */
    protected $updated;

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }
}