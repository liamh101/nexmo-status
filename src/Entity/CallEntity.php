<?php

namespace App\Entity;

use App\DataObject\CallObject;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CallEntityRepository")
 * @ORM\Table(name="call_log")
 *
 */
class CallEntity
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(type="string", unique=true)
     */
    private $callIdentifier;

    /**
     * @var EventEntity
     * @ORM\OneToOne(targetEntity="App\Entity\EventEntity")
     * @ORM\JoinColumn(name="latest_status", referencedColumnName="id", nullable=true)
     */
    private $latestStatus;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $callStart;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $fromNumber;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $toNumber;

    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     */
    private $callEnd;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\EventEntity", mappedBy="parent", orphanRemoval=true)
     */
    private $events;

    public function __construct(CallObject $callObject)
    {
        $this->createFromDataObject($callObject);
        $this->events = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCallIdentifier(): string
    {
        return $this->callIdentifier;
    }

    public function setCallIdentifier(string $callIdentifier): void
    {
        $this->callIdentifier = $callIdentifier;
    }

    public function getLatestStatus(): ?EventEntity
    {
        return $this->latestStatus;
    }

    public function setLatestStatus(EventEntity $latestStatus): void
    {
        $this->latestStatus = $latestStatus;
    }

    public function getStartDate(): ?\DateTimeImmutable
    {
        return $this->callStart;
    }

    public function setStartDate(\DateTimeImmutable $startDate): self
    {
        $this->callStart = $startDate;

        return $this;
    }

    public function getFromNumber(): ?string
    {
        return $this->fromNumber;
    }

    public function setFromNumber(string $fromNumber): self
    {
        $this->fromNumber = $fromNumber;

        return $this;
    }

    public function getToNumber(): ?string
    {
        return $this->toNumber;
    }

    public function setToNumber(string $toNumber): self
    {
        $this->toNumber = $toNumber;

        return $this;
    }

    public function getCallStart()
    {
        return $this->callStart;
    }

    public function setCallStart($callStart): void
    {
        $this->callStart = $callStart;
    }

    public function getCallEnd(): ?\DateTimeImmutable
    {
        return $this->callEnd;
    }

    public function setCallEnd(?\DateTimeImmutable $callEnd): self
    {
        $this->callEnd = $callEnd;

        return $this;
    }

    public function getEvents(): Collection
    {
        return $this->events;
    }

    public function addEvent(EventEntity $event): self
    {
        if (!$this->events->contains($event)) {
            $this->events[] = $event;
            $event->setParent($this);
        }

        return $this;
    }

    public function removeEvent(EventEntity $event): self
    {
        if ($this->events->contains($event)) {
            $this->events->removeElement($event);
            if ($event->getParent() === $this) {
                $event->setParent(null);
            }
        }

        return $this;
    }

    public function createFromDataObject(CallObject $callObject) : void
    {
        $this->callIdentifier = $callObject->getCallIdentifier();
        $this->callStart = $callObject->getCallStart();
        $this->fromNumber = $callObject->getFromNumber();
        $this->toNumber = $callObject->getToNumber();
        $this->latestStatus = $callObject->getLatestStatus();
    }
}
