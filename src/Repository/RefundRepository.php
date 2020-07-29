<?php

namespace App\Repository;

use App\Entity\Product;
use App\Entity\Refund;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\Persistence\ManagerRegistry;
use \DateTime;

/**
 * @method Refund|null find($id, $lockMode = null, $lockVersion = null)
 * @method Refund|null findOneBy(array $criteria, array $orderBy = null)
 * @method Refund[]    findAll()
 * @method Refund[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RefundRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Refund::class);
    }

    public function getTotalRefundByDate(DateTime $date = null)
    {

        if (null === $date) {
            $date = new DateTime('now');
        }
        $start = $date;
        $end   = clone $date;
        $start = $start->setTime(0, 0, 0);
        $end   = $end->setTime(23, 59);

        $result = $this->createQueryBuilder('r')
            ->andWhere('r.createdAt >= :start')
            ->setParameter('start', $start)
            ->andWhere('r.createdAt <= :end')
            ->setParameter('end', $end)
            ->select('SUM(r.amount) total')
            ->getQuery()
            ->getOneOrNullResult();

        return ($result['total']) ? $result['total'] : 0;

    }

    public function findAllByDateWithoutProduct($date = null)
    {
        if (null === $date) {
            $date = new DateTime('now');
        }
        $date = $date->format('Y-m-d');
        $start = new DateTime($date . 'T00:00:00');
        $end   = new DateTime($date . 'T23:59:59');

        $result = $this->createQueryBuilder('r')
            ->where('r.createdAt >= :start')
            ->setParameter('start', $start)
            ->andWhere('r.createdAt <= :end')
            ->setParameter('end', $end)
            ->andWhere('r.product is null')
            ->select('SUM(r.amount) total')
            ->getQuery()
            ->getOneOrNullResult();

        return ($result['total']) ? $result['total'] : 0;

    }

    public function findAllByDateWithProduct(DateTime $date = null)
    {
        if (null === $date) {
            $date = new DateTime('now');
        }
        $start = $date;
        $end   = clone $date;
        $start = $start->setTime(0, 0);
        $end   = $end->setTime(23, 59);

        $result = $this->createQueryBuilder('r')
            ->where('r.createdAt >= :start')
            ->setParameter('start', $start)
            ->andWhere('r.createdAt <= :end')
            ->setParameter('end', $end)
            ->andWhere('r.product is not null')
            ->select('SUM(r.amount) total')
            ->addSelect('SUM(r.quantity) quantity')
            ->join(Product::class, 'p', Join::WITH, 'r.product = p.id')
            ->addSelect('p.name product')
            ->groupBy('r.product')
            ->getQuery()
            ->getResult();

        return $result;

    }

    // /**
    //  * @return Refund[] Returns an array of Refund objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Refund
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
