<?php

declare(strict_types=1);

namespace App\Auth\Infra\OutputAdapter\Doctrine;

use App\Auth\Domain\Entity\User;
use App\Auth\Domain\Enum\RolUserEnum;
use App\Auth\Domain\OutputPort\UserRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<User>
 *
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User|null findOneByEmail(string $email)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepositoryImpl extends ServiceEntityRepository implements UserRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function findByEmail(string $email): ?User
    {
        return $this->findOneByEmail($email);
    }

    public function findByUsername(string $username): ?User
    {
        return $this->findOneByUsername($username);
    }

    public function save(User $entity): void
    {
        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush();
    }

    public function countActiveClients(): int
    {
        return (int) $this->createQueryBuilder('u')
            ->select('COUNT(u.idUser)')
            ->where('u.rol = :rol')
            ->andWhere('u.isActive = true')
            ->andWhere('u.isDeleted = false')
            ->setParameter('rol', RolUserEnum::ROLE_CLIENT)
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function countTotalUsers(): int
    {
        return (int) $this->createQueryBuilder('u')
            ->select('COUNT(u.idUser)')
            ->where('u.isDeleted = false')
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function countPremiumUsers(): int
    {
        return (int) $this->createQueryBuilder('u')
            ->select('COUNT(u.idUser)')
            ->where('u.isPremium = true')
            ->andWhere('u.isDeleted = false')
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function countNewUsersThisMonth(): int
    {
        $start = new \DateTime('first day of this month midnight');

        return (int) $this->createQueryBuilder('u')
            ->select('COUNT(u.idUser)')
            ->where('u.createdAt >= :start')
            ->andWhere('u.isDeleted = false')
            ->setParameter('start', $start)
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function findById(string $id): ?User
    {
        return $this->find($id);
    }

    /**
     * @return User[]
     */
    public function findPaginatedForAdmin(int $page, int $limit, ?string $search, ?string $role, ?bool $isPremium, ?bool $isActive): array
    {
        $qb = $this->createQueryBuilder('u')
            ->where('u.isDeleted = false')
            ->orderBy('u.createdAt', 'DESC')
            ->setFirstResult(($page - 1) * $limit)
            ->setMaxResults($limit);

        if ($search !== null) {
            $qb->andWhere('u.username LIKE :search OR u.email LIKE :search OR u.name LIKE :search')
               ->setParameter('search', '%' . $search . '%');
        }

        if ($role !== null) {
            $qb->andWhere('u.rol = :role')
               ->setParameter('role', RolUserEnum::from($role));
        }

        if ($isPremium !== null) {
            $qb->andWhere('u.isPremium = :isPremium')
               ->setParameter('isPremium', $isPremium);
        }

        if ($isActive !== null) {
            $qb->andWhere('u.isActive = :isActive')
               ->setParameter('isActive', $isActive);
        }

        return $qb->getQuery()->getResult();
    }

    public function countForAdmin(?string $search, ?string $role, ?bool $isPremium, ?bool $isActive): int
    {
        $qb = $this->createQueryBuilder('u')
            ->select('COUNT(u.idUser)')
            ->where('u.isDeleted = false');

        if ($search !== null) {
            $qb->andWhere('u.username LIKE :search OR u.email LIKE :search OR u.name LIKE :search')
               ->setParameter('search', '%' . $search . '%');
        }

        if ($role !== null) {
            $qb->andWhere('u.rol = :role')
               ->setParameter('role', RolUserEnum::from($role));
        }

        if ($isPremium !== null) {
            $qb->andWhere('u.isPremium = :isPremium')
               ->setParameter('isPremium', $isPremium);
        }

        if ($isActive !== null) {
            $qb->andWhere('u.isActive = :isActive')
               ->setParameter('isActive', $isActive);
        }

        return (int) $qb->getQuery()->getSingleScalarResult();
    }

    /**
     * @return User[]
     */
    public function findByRole(string $role): array
    {
        return $this->createQueryBuilder('u')
            ->where('u.rol = :role')
            ->andWhere('u.isDeleted = false')
            ->andWhere('u.isActive = true')
            ->setParameter('role', RolUserEnum::from($role))
            ->getQuery()
            ->getResult();
    }

    /**
     * @return User[]
     */
    public function findAllActive(): array
    {
        return $this->createQueryBuilder('u')
            ->where('u.isDeleted = false')
            ->andWhere('u.isActive = true')
            ->getQuery()
            ->getResult();
    }

    /**
     * @return array<array{month: string, newUsers: int, newPremium: int}>
     */
    public function getUsersGrowthByMonth(int $months): array
    {
        $since = new \DateTime('first day of -' . ($months - 1) . ' months midnight');

        $conn = $this->getEntityManager()->getConnection();
        $sql = "
            SELECT TO_CHAR(created_at, 'YYYY-MM') AS month,
                   COUNT(*) AS new_users,
                   SUM(CASE WHEN is_premium = true THEN 1 ELSE 0 END) AS new_premium
            FROM users
            WHERE created_at >= :since
              AND is_deleted = false
            GROUP BY TO_CHAR(created_at, 'YYYY-MM')
            ORDER BY month DESC
        ";

        $rows = $conn->fetchAllAssociative($sql, ['since' => $since->format('Y-m-d H:i:s')]);

        return array_map(fn(array $row) => [
            'month'      => $row['month'],
            'newUsers'   => (int) $row['new_users'],
            'newPremium' => (int) $row['new_premium'],
        ], $rows);
    }
}
