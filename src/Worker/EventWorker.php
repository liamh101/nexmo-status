<?php

namespace App\Worker;

use App\DataObject\CallObject;
use App\DataObject\EventObject;
use App\Entity\CallEntity;
use App\Entity\EventEntity;
use App\Repository\CallEntityRepository;
use App\Repository\EventEntityRepository;
use App\Service\CallService;
use Dtc\QueueBundle\Model\Worker;
use Psr\Log\LoggerInterface;

class EventWorker extends Worker
{
    /** @var CallEntityRepository */
    private $callRepository;

    /** @var CallService */
    private $callService;

    /** @var EventEntityRepository */
    private $eventRepository;

    /** @var LoggerInterface */
    private $logger;

    public function __construct(
        CallEntityRepository $callRepository,
        EventEntityRepository $eventRepository,
        CallService $callService,
        LoggerInterface $logger
    ) {
        $this->callRepository = $callRepository;
        $this->callService = $callService;
        $this->eventRepository = $eventRepository;
        $this->logger = $logger;
    }

    public function getName() : string
    {
        return 'event';
    }

    public function processEvent(array $content) : void
    {
        $callObject = new CallObject($content);
        $callEntity = $this->callRepository->findByIdentifier($callObject->getCallIdentifier());


        if (!$callEntity instanceof CallEntity) {
            $callEntity = $this->callService->createCall($callObject);
        }

        $eventObject = new EventObject($content);

        $eventEntity = new EventEntity($eventObject);
        $eventEntity->setParent($callEntity);

        $eventEntity = $this->eventRepository->saveEvent($eventEntity);

        $callEntity = $this->callService->updateCall($callEntity, $callObject);
        $callEntity = $this->callService->updateLatestStatus($callEntity, $eventEntity);
        $callEntity = $this->callService->addEventToCall($eventEntity, $callEntity);

        $this->callRepository->saveCall($callEntity);
    }
}