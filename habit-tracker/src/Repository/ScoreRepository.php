<?php

namespace App\Repository;

use App\Entity\Score;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Score>
 */
class ScoreRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Score::class);
    }

    /**
     * @return Score[] Returns an array of Score objects
     */
   public function findByUser($userId): array
   {
    return $this->createQueryBuilder('s')
            ->andWhere('s.user = :userId')
            ->setParameter('userId', $userId)
            ->orderBy('s.dateCreated', 'DESC')
            ->getQuery()
            ->getResult();
   }

   /**
     * @return Score|null Returns the highest score for a user
     */
    public function findHighestScoreForUser($userId): ?Score
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.user = :userId')
            ->setParameter('userId', $userId)
            ->orderBy('s.value', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * @return Score[] Returns an array of all scores ordered by value (descending)
     */
    public function findAllOrderedByValue(): array
    {
        return $this->createQueryBuilder('s')
            ->orderBy('s.value', 'DESC')
            ->getQuery()
            ->getResult();
    }
}