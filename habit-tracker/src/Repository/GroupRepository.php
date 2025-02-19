<?php

namespace App\Repository;

use App\Entity\Group;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Group>
 */
class GroupRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Group::class);
    }

    /**
     * @return un groupe par son nom.
     */

    public function findOneByName(string $name): ?Group
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.name = :name')
            ->setParameter('name', $name)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * Retourne tous les groupes triés par nom.
     */
    public function findAllGroups(): array
    {
        return $this->findBy([], ['name' => 'ASC']);
    }

    /**
     * Retourne les groupes qui contiennent un membre spécifique.
     */
    public function findGroupsByMember(User $user): array
    {
        return $this->createQueryBuilder('g')
            ->join('g.members','m')
            ->where('m.id = :userId')
            ->setParameter('userId', $user->getId())
            ->getQuery()
            ->getResult();
    }
}