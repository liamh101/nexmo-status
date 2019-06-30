<?php

namespace App\Transformer;

use App\Entity\CallEntity;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use League\Fractal\TransformerAbstract;

class CallTransformer extends TransformerAbstract
{
    public const INCLUDE_EVENTS = 'events';
    public const INCLUDE_LATEST_STATUS = 'latestStatus';

    protected $availableIncludes = [
        self::INCLUDE_EVENTS,
        self::INCLUDE_LATEST_STATUS,
    ];

    protected $defaultIncludes = [
        self::INCLUDE_EVENTS,
        self::INCLUDE_LATEST_STATUS,
    ];

    public function transform(CallEntity $call) : array
    {
        return [
            'id' => $call->getId(),
            'callIdentifier' => $call->getCallIdentifier(),
            'fromNumber' => $call->getFromNumber(),
            'toNumber' => $call->getToNumber(),
            'callStart' => $call->getStartDate()->format('c'),
            'callEnd' => $call->getCallEnd() instanceof \DateTimeImmutable ? $call->getCallEnd()->format('c') : null,
        ];
    }

    public function includeLatestStatus(CallEntity $call) : Item
    {
        return $this->item($call->getLatestStatus(), new EventTransformer());
    }

    public function includeEvents(CallEntity $call) : Collection
    {
        return $this->collection($call->getEvents(), new EventTransformer());
    }
}