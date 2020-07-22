<?php

namespace App\Repository;

use App\Entity\CashCount;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CashCount|null find($id, $lockMode = null, $lockVersion = null)
 * @method CashCount|null findOneBy(array $criteria, array $orderBy = null)
 * @method CashCount[]    findAll()
 * @method CashCount[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CashCountRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CashCount::class);
    }

    // /**
    //  * @return CashCount[] Returns an array of CashCount objects
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
    public function findOneBySomeField($value): ?CashCount
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
