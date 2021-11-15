<?php

namespace App\Repository;

use App\Entity\FinalAnswer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method FinalAnswer|null find($id, $lockMode = null, $lockVersion = null)
 * @method FinalAnswer|null findOneBy(array $criteria, array $orderBy = null)
 * @method FinalAnswer[]    findAll()
 * @method FinalAnswer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FinalAnswerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FinalAnswer::class);
    }

    // /**
    //  * @return FinalAnswer[] Returns an array of FinalAnswer objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?FinalAnswer
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
