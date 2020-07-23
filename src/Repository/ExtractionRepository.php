<?php

namespace App\Repository;

use App\Entity\Extraction;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use \DateTime;

/**
 * @method Extraction|null find($id, $lockMode = null, $lockVersion = null)
 * @method Extraction|null findOneBy(array $criteria, array $orderBy = null)
 * @method Extraction[]    findAll()
 * @method Extraction[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ExtractionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Extraction::class);
    }

    public function getTotalExtractions($date = null)
    {
        if (null === $date) {
            $date = new DateTime('now');
        }
        $date = $date->format('Y-m-d');
        $start = new DateTime($date . 'T00:00:00');
        $end   = new DateTime($date . 'T23:59:59');

        $result = $this->createQueryBuilder('e')
            ->andWhere('e.createdAt >= :start')
            ->setParameter('start', $start)
            ->andWhere('e.createdAt <= :end')
            ->setParameter('end', $end)
            ->select('SUM(e.amount) total')
            ->getQuery()
            ->getOneOrNullResult()
            ;
        return ($result['total']) ? $result['total'] : 0;
    }

    // /**
    //  * @return Extraction[] Returns an array of Extraction objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Extraction
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
