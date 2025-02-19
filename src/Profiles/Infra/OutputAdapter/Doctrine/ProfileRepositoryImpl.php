<?php

declare(strict_types=1);

namespace App\Profiles\Infra\OutputAdapter\Doctrine;

use App\Auth\Domain\Entity\User;
use App\Profiles\Domain\Entity\Follow;
use App\Profiles\Domain\OutputPort\ProfileRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<User>
 *
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProfileRepositoryImpl extends ServiceEntityRepository implements ProfileRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function findAllFollowerProfiles(string $username): array
    {
        // Subconsulta para obtener el idUser
        $subQuery = $this->createQueryBuilder('u2')
            ->select('u2.idUser')
            ->where('u2.username = :username')
            ->getDQL();

        // Consulta principal usando la subconsulta
        return $this->createQueryBuilder('u')
            ->select('u')
            ->innerJoin(Follow::class, 'f', 'WITH', 'f.follower = u.idUser')
            ->where("f.followed IN ($subQuery)")
            ->setParameter('username', $username)
            ->getQuery()
            ->getResult();
    }

    public function findAllFollowingProfiles(string $username): array
    {
        // Subconsulta para obtener el idUser
        $subQuery = $this->createQueryBuilder('u2')
        ->select('u2.idUser')
        ->where('u2.username = :username')
        ->getDQL();

        // Consulta principal usando la subconsulta
        return $this->createQueryBuilder('u')
            ->select('u')
            ->innerJoin(Follow::class, 'f', 'WITH', 'f.followed = u.idUser')
            ->where("f.follower IN ($subQuery)")
            ->setParameter('username', $username)
            ->getQuery()
            ->getResult();
    }

    public function countFollowerProfiles(string $username): int
    {
        // Subconsulta para obtener el idUser
        $subQuery = $this->createQueryBuilder('u2')
        ->select('u2.idUser')
        ->where('u2.username = :username')
        ->getDQL();

        return $this->createQueryBuilder('u')
            ->select('COUNT(u)')
            ->innerJoin(Follow::class, 'f', 'WITH', 'f.follower = u.idUser')
            ->where("f.followed IN ($subQuery)")
            ->setParameter('username', $username)
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function countFollowingProfiles(string $username): int
    {
        // Subconsulta para obtener el idUser
        $subQuery = $this->createQueryBuilder('u2')
        ->select('u2.idUser')
        ->where('u2.username = :username')
        ->getDQL();

        return $this->createQueryBuilder('u')
            ->select('COUNT(u)')
            ->innerJoin(Follow::class, 'f', 'WITH', 'f.followed = u.idUser')
            ->where("f.follower IN ($subQuery)")
            ->setParameter('username', $username)
            ->getQuery()
            ->getSingleScalarResult();
    }
}
