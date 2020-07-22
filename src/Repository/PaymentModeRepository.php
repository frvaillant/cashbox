<?php

namespace App\Repository;

use App\Entity\PaymentMode;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PaymentMode|null find($id, $lockMode = null, $lockVersion = null)
 * @method PaymentMode|null findOneBy(array $criteria, array $orderBy = null)
 * @method PaymentMode[]    findAll()
 * @method PaymentMode[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PaymentModeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PaymentMode::class);
    }

    // /**
    //  * @return PaymentMode[] Returns an array of PaymentMode objects
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
    public function findOneBySomeField($value): ?PaymentMode
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
