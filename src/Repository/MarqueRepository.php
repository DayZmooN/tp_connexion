<?php

namespace App\Repository;

use App\Entity\Marque;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Marque>
 */
class MarqueRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Marque::class);
    }

    //    /**
    //     * @return Marque[] Returns an array of Marque objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('m')
    //            ->andWhere('m.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('m.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

        public function findActiveMarque()
        {

            return $this->createQueryBuilder('m')
                ->where('m.archive = true')
                ->getQuery()
                ->getResult()
            ;
        }

    public function findDesactiveMarque()
    {
        return $this->createQueryBuilder('m')
            ->where('m.archive = false')
            ->getQuery()
            ->getResult();
    }
}
