<?php

namespace App\DataObject;

use App\Entity\CallEntity;
use DateTimeImmutable;

class EventObject
{
    /** @var CallEntity */
    private $parent;

    /** @var string */
    private $status;

    /** @var string */
    private $direction;

    /** @var DateTimeImmutable */
    private $timestamp;

    public function __construct(array $data)
    {
        if (isset($data['status'])) {
            $this->status = $data['status'];
        }

        if (isset($data['direction'])) {
            $this->direction = $data['direction'];
        }

        if (isset($data['timestamp'])) {
            $this->timestamp = new DateTimeImmutable($data['timestamp']);
        }
    }

    /**
     * @return CallEntity
     */
    public function getParent(): CallEntity
    {
        return $this->parent;
    }

    /**
     * @param CallEntity $parent
     */
    public function setParent(CallEntity $parent): void
    {
        $this->parent = $parent;
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
     * @return string
     */
    public function getDirection(): string
    {
        return $this->direction;
    }

    /**
     * @param string $direction
     */
    public function setDirection(string $direction): void
    {
        $this->direction = $direction;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getTimestamp(): DateTimeImmutable
    {
        return $this->timestamp;
    }

    /**
     * @param DateTimeImmutable $timestamp
     */
    public function setTimestamp(DateTimeImmutable $timestamp): void
    {
        $this->timestamp = $timestamp;
    }
}