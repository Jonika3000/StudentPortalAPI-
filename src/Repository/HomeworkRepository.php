<?php

namespace App\Repository;

use App\Entity\Homework;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Homework>
 */
class HomeworkRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Homework::class);
    }

    public function saveAction(Homework $homework): void
    {
        $entityManager = $this->getEntityManager();

        $entityManager->persist($homework);
        $entityManager->flush();
    }

    public function deleteAction(Homework $homework): void
    {
        $entityManager = $this->getEntityManager();
        $entityManager->remove($homework);
        $entityManager->flush();
    }

    //    /**
    //     * @return Homework[] Returns an array of Homework objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('h')
    //            ->andWhere('h.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('h.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Homework
    //    {
    //        return $this->createQueryBuilder('h')
    //            ->andWhere('h.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
