<?php

namespace App\Transformer;

use App\Entity\EventEntity;
use League\Fractal\TransformerAbstract;

class EventTransformer extends TransformerAbstract
{

    public function transform(EventEntity $event) : array
    {
        return [
            'id' => $event->getId(),
            'direction' => $event->getDirection(),
            'timestamp' => $event->getTimestamp()->format('c'),
            'status' => $event->getStatus(),
        ];
    }
}