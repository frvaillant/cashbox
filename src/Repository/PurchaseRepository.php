<?php

namespace App\Repository;

use App\Entity\PaymentMode;
use App\Entity\Purchase;
use App\Entity\Refund;
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
        $start = $date->setTime(0, 0);
        $end   = clone $start;
        $end->setTime(23, 59);

        $result = $this->createQueryBuilder('p')
            ->andWhere('p.createdAt >= :start')
            ->setParameter('start', $start)
            ->andWhere('p.createdAt <= :end')
            ->setParameter('end', $end)
            ->select('SUM(p.totalAmount) total')
            ->getQuery()
            ->getOneOrNullResult();
        return ($result['total']) ? $result['total'] : 0;
    }

    public function getCurrentCash($date = null)
    {
        if(null === $date) {
            $date = new DateTime('now');
        }
        $start = $date->setTime(0, 0);
        $end   = clone $start;
        $end->setTime(23, 59);

        $result = $this->createQueryBuilder('p')
            ->andWhere('p.createdAt >= :start')
            ->setParameter('start', $start)
            ->andWhere('p.createdAt <= :end')
            ->setParameter('end', $end)
            ->join(PaymentMode::class, 'pm', Join::WITH, 'pm.id = p.paymentMode')
            ->andWhere('pm.identifier = :identifier')
            ->setParameter('identifier', self::CASH)
            ->select('SUM(p.totalAmount) total')
            ->getQuery()
            ->getOneOrNullResult();
        return ($result['total']) ? $result['total'] : 0;
    }

    public function findAllByDate(DateTime $date)
    {
        $start = $date->setTime(0, 0);
        $end = clone $start;
        $end->setTime(23, 59);

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

    public function getTotalByPaymentModeToday(DateTime $date = null)
    {
        if (null === $date) {
            $date = new DateTime('now');
        }
        $start = $date->setTime(0, 0);
        $end = clone $start;
        $end->setTime(23, 59);

        return $this->createQueryBuilder('p')
            ->andWhere('p.createdAt >= :start')
            ->setParameter('start', $start)
            ->andWhere('p.createdAt <= :end')
            ->setParameter('end', $end)
            ->select('SUM(p.totalAmount) total')
            ->addSelect('count(p.id) counter')
            ->join(PaymentMode::class, 'pm', Join::WITH, 'p.paymentMode = pm.id')
            ->addSelect('pm.name')
            ->groupBy('pm.name')
            ->getQuery()
            ->getResult();
    }

    public function getTotalByPaymentModePeriod(DateTime $from, DateTime $to)
    {
        $start = $from->setTime(0, 0);
        $end   = $to->setTime(23, 59);

        return $this->createQueryBuilder('p')
            ->andWhere('p.createdAt >= :start')
            ->setParameter('start', $start)
            ->andWhere('p.createdAt <= :end')
            ->setParameter('end', $end)
            ->select('DATE(p.createdAt) date')
            ->addSelect('p.totalAmount total')
            ->join(PaymentMode::class, 'pm', Join::WITH, 'p.paymentMode = pm.id')
            ->addSelect('pm.name payment_mode')
            ->addSelect('pm.identifier identifier')
            ->orderBy('date', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }


}
