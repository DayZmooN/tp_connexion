<?php

namespace App\Repository;

use App\Entity\Voiture;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Voiture>
 */
class VoitureRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Voiture::class);
    }

    //    /**
    //     * @return VoitureFixture[] Returns an array of VoitureFixture objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('v')
    //            ->andWhere('v.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('v.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

        public function findVoitureActive()
        {
            return $this->createQueryBuilder('v')
                ->where('v.archive = true')
                ->getQuery()
                ->getResult()
            ;
        }

    public function findVoitureDesactive()
    {
        return $this->createQueryBuilder('v')
            ->where('v.archive = false')
            ->getQuery()
            ->getResult();
    }
}
