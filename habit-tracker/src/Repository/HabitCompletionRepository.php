<?php

namespace App\Repository;

use App\Entity\HabitCompletion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<HabitCompletion>
 */
class HabitCompletionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, HabitCompletion::class);
    }

   /**
     * @return les complétions d'une habitude spécifique.
     * 
     * @param int $habitId
     * @return HabitCompletion[] 
    */
    public function findByHabit(int $habitId): array
    {
        return $this->createQueryBuilder('hc')
            ->andWhere('hc.habit = :habitId')
            ->setParameter('habitId', $habitId)
            ->orderBy('hc.completedAt', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Retourne les complétions pour un utilisateur donné.
     *
     * @param int $userId
     * @return HabitCompletion[]
     */

    public function findByUser(int $userId): array
    {
        return $this->createQueryBuilder('hc')
            ->andWhere('hc.user = :userId')
            ->setParameter('userId', $userId)
            ->orderBy('hc.completedAt', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Retourne une complétion par son ID.
     *
     * @param int $completionId
     * @return HabitCompletion|null
     */
    public function findOneById(int $completionId): ?HabitCompletion
    {
        return $this->find($completionId);
    }
}
