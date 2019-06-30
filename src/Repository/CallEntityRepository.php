<?php

namespace App\Repository;

use App\Entity\CallEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Psr\Log\LoggerInterface;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method CallEntity|null find($id, $lockMode = null, $lockVersion = null)
 * @method CallEntity|null findOneBy(array $criteria, array $orderBy = null)
 * @method CallEntity[]    findAll()
 * @method CallEntity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CallEntityRepository extends ServiceEntityRepository
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(RegistryInterface $registry, LoggerInterface $logger)
    {
        parent::__construct($registry, CallEntity::class);
        $this->logger = $logger;
    }

    /**
     * @param string $identifier
     * @return CallEntity|null
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findByIdentifier(string $identifier) : ?CallEntity
    {
        $test = $this->createQueryBuilder('c')
            ->andWhere('c.callIdentifier = :identifier')
            ->setParameter('identifier', $identifier)
            ->getQuery()
            ->getOneOrNullResult();

        return $test;
    }

    public function saveCall(CallEntity $call) : CallEntity
    {
        try {
            $this->getEntityManager()->persist($call);
            $this->getEntityManager()->flush();

        } catch (\Exception $e) {
            var_dump('Exception');
            $this->logger->debug($e->getMessage());
        }

        return $call;
    }

    // /**
    //  * @return CallEntity[] Returns an array of CallEntity objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CallEntity
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
