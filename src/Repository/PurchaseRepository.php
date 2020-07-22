<?php

namespace App\Repository;

use App\Entity\Purchase;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use \DateTime;

/**
 * @method Purchase|null find($id, $lockMode = null, $lockVersion = null)
 * @method Purchase|null findOneBy(array $criteria, array $orderBy = null)
 * @method Purchase[]    findAll()
 * @method Purchase[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PurchaseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Purchase::class);
    }

    public function getTotalByDay(DateTime $date)
    {
        $date = $date->format('Y-m-d');
        $start = new DateTime($date . 'T00:00:00');
        $end   = new DateTime($date . 'T23:59:59');

        return $this->createQueryBuilder('p')
            ->andWhere('p.createdAt >= :start')
            ->setParameter('start', $start)
            ->andWhere('p.createdAt <= :end')
            ->setParameter('end', $end)
            ->select('SUM(p.totalAmount) total')
            ->getQuery()
            ->getOneOrNullResult();
    }

    // /**
    //  * @return Purchase[] Returns an array of Purchase objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Purchase
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
