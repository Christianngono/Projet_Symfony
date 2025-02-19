<?php

namespace App\Repository;

use App\Entity\Invitation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Invitation>
 */
class InvitationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Invitation::class);
    }

    /**
     * @return toutes les invitations envoyées par un utilisateur.
     *
     * @param int $userId
     * @return Invitation[]
     */
    public function findBySender(int $userId): array
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.sender = :userId')
            ->setParameter('userId', $userId)
            ->orderBy('i.sentAt', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Retourne toutes les invitations reçues par un utilisateur.
     *
     * @param int $userId
     * @return Invitation[]
     */
    public function findByReceiver(int $userId): array
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.receiver = :userId')
            ->setParameter('userId', $userId)
            ->orderBy('i.sentAt', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Retourne une invitation par son ID.
     *
     * @param int $invitationId
     * @return Invitation|null
     */
    public function findOneById(int $invitationId): ?Invitation
    {
        return $this->find($invitationId);
    }

    /**
     * Retourne toutes les invitations en attente.
     *
     * @return Invitation[]
     */
    public function findPendingInvitations(): array
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.status = :status')
            ->setParameter('status', 'pending')
            ->orderBy('i.sentAt', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Retourne toutes les invitations acceptées par un utilisateur.
     *
     * @param int $userId
     * @return Invitation[]
     */
    public function findAcceptedInvitationsByUser(int $userId): array
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.receiver = :userId AND i.status = :status')
            ->setParameter('userId', $userId)
            ->setParameter('status', 'accepted')
            ->orderBy('i.sentAt', 'DESC')
            ->getQuery()
            ->getResult();
    }
}