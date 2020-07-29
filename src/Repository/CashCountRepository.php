<?php

namespace App\Repository;

use App\Entity\CashCount;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use \DateTime;

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

    public function getTotayCashCount()
    {
        $start = new DateTime('now');
        $end   = clone $start;
        $start = $start->setTime(0, 0);
        $end   = $end->setTime(23, 59);

        $result = $this->createQueryBuilder('c')
            ->select('c.amount')
            ->andWhere('c.createdAt >= :start')
            ->setParameter('start', $start)
            ->andWhere('c.createdAt <= :end')
            ->setParameter('end', $end)
            ->orderBy('c.createdAt', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult()
            ;
        return ($result) ? $result['amount'] : null;
    }

    public function hasBeenCountedToday(): bool
    {
        $start = new DateTime('now');
        $start->setTime(0, 0);
        $end = clone $start;
        $end   = $end->setTime(23, 59);

        $result = $this->createQueryBuilder('c')
            ->select('c.amount')
            ->andWhere('c.createdAt >= :start')
            ->setParameter('start', $start)
            ->andWhere('c.createdAt <= :end')
            ->setParameter('end', $end)
            ->orderBy('c.createAt', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult()
        ;
        $response = false;
        if($result) {
            $response = true;
        }
        return $response;
    }
}
