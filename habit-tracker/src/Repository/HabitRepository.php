<?php

namespace App\Repository;

use App\Entity\Habit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Habit>
 */
class HabitRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Habit::class);
    }

    /**
     * @return les habitudes d'un utilisateur donné
     * @param int $userId
     * @return Habit[]
     */
    public function findByUser(int $userId): array
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.user = :userId')
            ->setParameter('userId', $userId)
            ->orderBy('h.createdAt', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Retourne les habitudes triées par date de création.
     *
     * @return Habit[]
     */
    public function findAllOrderedByDate(): array
    {
        return $this->createQueryBuilder('h')
            ->orderBy('h.createdAt', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Retourne une habitude par son ID.
     *
     * @param int $habitId
     * @return Habit|null
     */


    public function findOneById(int $habitId): ?Habit
    {
        return $this->find($habitId);
    }
}