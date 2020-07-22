<?php

namespace App\Repository;

use App\Entity\CashFund;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CashFund|null find($id, $lockMode = null, $lockVersion = null)
 * @method CashFund|null findOneBy(array $criteria, array $orderBy = null)
 * @method CashFund[]    findAll()
 * @method CashFund[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CashFundRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CashFund::class);
    }

    // /**
    //  * @return CashFund[] Returns an array of CashFund objects
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
    public function findOneBySomeField($value): ?CashFund
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
