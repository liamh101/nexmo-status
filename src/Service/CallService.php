<?php
namespace App\Service;

use App\DataObject\CallObject;
use App\DataObject\EventObject;
use App\Entity\CallEntity;
use App\Entity\EventEntity;
use App\Repository\CallEntityRepository;
use Psr\Log\LoggerInterface;

class CallService
{

    /** @var CallEntityRepository */
    private $callRepository;

    /** @var LoggerInterface */
    private $logger;

    public function __construct(CallEntityRepository $callRepository, LoggerInterface $logger)
    {
        $this->callRepository = $callRepository;
        $this->logger = $logger;
    }

    public function createCall(CallObject $data) : CallEntity
    {
        $this->logger->debug('About to create call');
        return $this->callRepository->saveCall(new CallEntity($data));
    }

    public function updateCall(CallEntity $callEntity, CallObject $callObject) : CallEntity
    {
        if ($callObject->getCallEnd() instanceof \DateTimeImmutable) {
            $callEntity->setCallEnd($callObject->getCallEnd());
        }
        return $callEntity;
    }

    public function updateLatestStatus(CallEntity $callEntity, EventEntity $eventEntity) : CallEntity
    {
        $previousLatestStatus = $callEntity->getLatestStatus();

        $this->logger->debug('Compare Status');
        if ($previousLatestStatus instanceof EventEntity && $eventEntity->getTimestamp() > $previousLatestStatus->getTimestamp()) {
            $this->logger->debug('Status is higher');

            $callEntity->setLatestStatus($eventEntity);
        }

        if (!$previousLatestStatus instanceof EventEntity) {
            $callEntity->setLatestStatus($eventEntity);
        }

        return $callEntity;
    }

    public function addEventToCall(EventEntity $event, CallEntity $callEntity) : CallEntity
    {
        $callEntity->addEvent($event);

        return $callEntity;
    }
}