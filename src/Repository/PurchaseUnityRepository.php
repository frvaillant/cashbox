<?php

namespace App\Repository;

use App\Entity\Category;
use App\Entity\Product;
use App\Entity\Purchase;
use App\Entity\PurchaseUnity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\Persistence\ManagerRegistry;
use \DateTime;

/**
 * @method PurchaseUnity|null find($id, $lockMode = null, $lockVersion = null)
 * @method PurchaseUnity|null findOneBy(array $criteria, array $orderBy = null)
 * @method PurchaseUnity[]    findAll()
 * @method PurchaseUnity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PurchaseUnityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PurchaseUnity::class);
    }

    public function getTotalByProductToday(DateTime $date = null)
    {
        if (null === $date) {
            $date = new DateTime('now');
        }
        $date = $date->format('Y-m-d');
        $start = new DateTime($date . 'T00:00:00');
        $end   = new DateTime($date . 'T23:59:59');

        return $this->createQueryBuilder('pu')
            ->andWhere('pr.createdAt >= :start')
            ->setParameter('start', $start)
            ->andWhere('pr.createdAt <= :end')
            ->setParameter('end', $end)
            ->select('SUM(pu.productPrice * pu.quantity) total')
            ->addSelect('SUM(pu.quantity) quantity')
            ->join(Product::class, 'p', Join::WITH, 'p.id = pu.product')
            ->join(Purchase::class, 'pr', Join::WITH, 'pr.id = pu.purchase')
            ->addSelect('p.name')
            ->groupBy('p.name')
            ->orderBy('p.name', 'ASC')
            ->getQuery()
            ->getResult();
    }

    // /**
    //  * @return PurchaseUnity[] Returns an array of PurchaseUnity objects
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
    public function findOneBySomeField($value): ?PurchaseUnity
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
