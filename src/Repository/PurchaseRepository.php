<?php

namespace App\Repository;

use App\Entity\PaymentMode;
use App\Entity\Purchase;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr\Join;
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
    const CASH = 'CASH';

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Purchase::class);
    }

    public function getTotalByDay(DateTime $date = null)
    {
        if (null === $date) {
            $date = new DateTime('now');
        }
        $date = $date->format('Y-m-d');
        $start = new DateTime($date . 'T00:00:00');
        $end   = new DateTime($date . 'T23:59:59');

        $result = $this->createQueryBuilder('p')
            ->andWhere('p.createdAt >= :start')
            ->setParameter('start', $start)
            ->andWhere('p.createdAt <= :end')
            ->setParameter('end', $end)
            ->select('SUM(p.totalAmount) total')
            ->getQuery()
            ->getOneOrNullResult();
        return $result['total'];
    }

    public function getCurrentCash()
    {
        $date = new DateTime('now');
        $date = $date->format('Y-m-d');
        $start = new DateTime($date . 'T00:00:00');
        $end   = new DateTime($date . 'T23:59:59');

        return $this->createQueryBuilder('p')
            ->andWhere('p.createdAt >= :start')
            ->setParameter('start', $start)
            ->andWhere('p.createdAt <= :end')
            ->setParameter('end', $end)
            ->join(PaymentMode::class, 'pm', Join::ON, 'pm.id = p.paymentMode')
            ->andWhere('pm.identifier = :identifier')
            ->setParameter('identifier', self::CASH)
            ->select('SUM(p.totalAmount) total')
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function findAllByDate(DateTime $date)
    {
        $date = $date->format('Y-m-d');
        $start = new DateTime($date . 'T00:00:00');
        $end   = new DateTime($date . 'T23:59:59');

        return $this->createQueryBuilder('p')
            ->andWhere('p.createdAt >= :start')
            ->setParameter('start', $start)
            ->andWhere('p.createdAt <= :end')
            ->join(PaymentMode::class, 'pm', Join::WITH, 'p.paymentMode = pm.id')
            ->setParameter('end', $end)
            ->orderBy('p.createdAt', 'DESC')
            ->getQuery()
            ->getResult();
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
