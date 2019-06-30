<?php

namespace App\Entity;

use App\DataObject\EventObject;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EventEntityRepository")
 * @ORM\Table(name="event")
 */
class EventEntity
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $status;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $direction;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $timestamp;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\CallEntity", inversedBy="events")
     * @ORM\JoinColumn(nullable=false)
     */
    private $parent;

    public function __construct(EventObject $eventObject)
    {
        $this->status = $eventObject->getStatus();
        $this->timestamp = $eventObject->getTimestamp();
        $this->direction = $eventObject->getDirection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getDirection(): ?string
    {
        return $this->direction;
    }

    public function setDirection(string $direction): self
    {
        $this->direction = $direction;

        return $this;
    }

    public function getTimestamp(): ?\DateTimeImmutable
    {
        return $this->timestamp;
    }

    public function setTimestamp(\DateTimeImmutable $timestamp): self
    {
        $this->timestamp = $timestamp;

        return $this;
    }

    public function getParent(): ?CallEntity
    {
        return $this->parent;
    }

    public function setParent(?CallEntity $parent): self
    {
        $this->parent = $parent;

        return $this;
    }
}
