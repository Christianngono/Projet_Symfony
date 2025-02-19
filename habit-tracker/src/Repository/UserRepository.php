<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\QueryBuilder;


/**
 * @extends ServiceEntityRepository<User>
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * Méthode pour trouver un utilisateur par email.
    */
    public function findOneByEmail(string $email): ?User
    {
       return $this->createQueryBuilder('u')
            ->andWhere('u.email= :email')
            ->setParameter('email', $email)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * Méthode pour récupérer tous les utilisateurs.
     */
    public function findAllUsers(): array
    {
        return $this->findBy([], ['id' => 'ASC']);
    }

    /**
     * Méthode pour chercher les utilisateurs avec un pseudo spécifique.
     */
    public function findUsersByPseudo(string $pseudo): array
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.pseudo LIKE :pseudo')
            ->setParameter('pseudo', '%'.$pseudo.'%')
            ->orderBy('u.id', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Exemple de requête personnalisée avec des critères spécifiques.
     */
    public function findActiveUsers(): array
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.isActive = :isActive')
            ->setParameter('isActive', true)
            ->getQuery()
            ->getResult();
    }
}
