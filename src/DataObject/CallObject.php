<?php

namespace App\DataObject;

use App\Entity\EventEntity;
use DateTimeImmutable;

class CallObject
{
    /**
     * @var string
     */
    private $callIdentifier;

    /**
     * @var EventEntity
     */
    private $latestStatus;

    /**
     * @var DateTimeImmutable
     */
    private $callStart;

    /**
     * @var DateTimeImmutable|null
     */
    private $callEnd;

    /**
     * @var string
     */
    private $fromNumber;

    /**
     * @var string
     */
    private $toNumber;

    public function __construct(array $call)
    {
        if (isset($call['conversation_uuid'])) {
            $this->callIdentifier = $call['conversation_uuid'];
        }

        if (isset($call['timestamp'])) {
            $this->callStart = new DateTimeImmutable($call['timestamp']);
        }

        if (isset($call['end_time'])) {
            $this->callEnd = new DateTimeImmutable($call['end_time']);
        }

        if (isset($call['from'])) {
            $this->fromNumber = $call['from'];
        }

        if (isset($call['to'])) {
            $this->toNumber = $call['to'];
        }
    }

    /**
     * @return string
     */
    public function getCallIdentifier(): string
    {
        return $this->callIdentifier;
    }

    /**
     * @param string $callIdentifier
     */
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

    /**
     * @return DateTimeImmutable
     */
    public function getCallStart(): DateTimeImmutable
    {
        return $this->callStart;
    }

    /**
     * @param DateTimeImmutable $callStart
     */
    public function setCallStart(DateTimeImmutable $callStart): void
    {
        $this->callStart = $callStart;
    }

    /**
     * @return DateTimeImmutable|null
     */
    public function getCallEnd(): ?DateTimeImmutable
    {
        return $this->callEnd;
    }

    /**
     * @param DateTimeImmutable $callEnd
     */
    public function setCallEnd(DateTimeImmutable $callEnd): void
    {
        $this->callEnd = $callEnd;
    }

    /**
     * @return string
     */
    public function getFromNumber(): string
    {
        return $this->fromNumber;
    }

    /**
     * @param string $fromNumber
     */
    public function setFromNumber(string $fromNumber): void
    {
        $this->fromNumber = $fromNumber;
    }

    /**
     * @return string
     */
    public function getToNumber(): string
    {
        return $this->toNumber;
    }

    /**
     * @param string $toNumber
     */
    public function setToNumber(string $toNumber): void
    {
        $this->toNumber = $toNumber;
    }
}