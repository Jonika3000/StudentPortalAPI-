<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;

/**
 * @extends ServiceEntityRepository<User>
 */
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', $user::class));
        }

        $user->setPassword($newHashedPassword);
        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();
    }

    public function saveUser(User $user): void
    {
        $entityManager = $this->getEntityManager();
        $entityManager->persist($user);
        $entityManager->flush();
    }

    public function getFilteredUsersQuery(): \Doctrine\ORM\QueryBuilder
    {
        $entityManager = $this->getEntityManager();
        $subqueryStudent = $entityManager->createQueryBuilder()
            ->select('IDENTITY(s.associatedUser)')
            ->from('App\Entity\Student', 's');

        $subqueryTeacher = $entityManager->createQueryBuilder()
            ->select('IDENTITY(t.associatedUser)')
            ->from('App\Entity\Teacher', 't');

        $qb = $entityManager->createQueryBuilder();
        $qb->select('u')
            ->from('App\Entity\User', 'u')
            ->where(
                $qb->expr()->notIn('u.id', $subqueryStudent->getDQL())
            )
            ->andWhere(
                $qb->expr()->notIn('u.id', $subqueryTeacher->getDQL())
            );

        return $qb;
    }
}
