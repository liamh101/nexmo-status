<?php

namespace App\Repository;

use App\Entity\EventEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Psr\Log\LoggerInterface;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method EventEntity|null find($id, $lockMode = null, $lockVersion = null)
 * @method EventEntity|null findOneBy(array $criteria, array $orderBy = null)
 * @method EventEntity[]    findAll()
 * @method EventEntity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EventEntityRepository extends ServiceEntityRepository
{
    /** @var LoggerInterface */
    private $logger;

    public function __construct(RegistryInterface $registry, LoggerInterface $logger)
    {
        parent::__construct($registry, EventEntity::class);
        $this->logger = $logger;
    }

    public function saveEvent(EventEntity $event) : EventEntity
    {
        try {
            $this->getEntityManager()->persist($event);
            $this->getEntityManager()->flush();
        } catch (\Exception $e) {
            $this->logger->debug($e->getMessage());
        }


        return $event;
    }
}
