<?php

namespace App\Repository;

use App\Entity\PurchaseUnity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

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
