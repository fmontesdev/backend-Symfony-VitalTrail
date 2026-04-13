<?php

declare(strict_types=1);

namespace App\Notifications\Infra\OutputAdapter\Doctrine;

use App\Notifications\Domain\Entity\NotificationsUsers;
use App\Notifications\Domain\OutputPort\NotificationsUsersRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<NotificationsUsers>
 *
 * @method NotificationsUsers|null find($id, $lockMode = null, $lockVersion = null)
 * @method NotificationsUsers|null findOneBy(array $criteria, array $orderBy = null)
 * @method NotificationsUsers[]    findAll()
 * @method NotificationsUsers[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NotificationsUsersRepositoryImpl extends ServiceEntityRepository implements NotificationsUsersRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, NotificationsUsers::class);
    }

    public function save(NotificationsUsers $nu): void
    {
        $this->getEntityManager()->persist($nu);
        $this->getEntityManager()->flush();
    }

    /**
     * @return NotificationsUsers[]
     */
    public function findByUser(string $userId): array
    {
        return $this->createQueryBuilder('nu')
            ->join('nu.notification', 'n')
            ->where('IDENTITY(nu.user) = :userId')
            ->setParameter('userId', $userId)
            ->orderBy('n.createdAt', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function countUnreadByUser(string $userId): int
    {
        return (int) $this->createQueryBuilder('nu')
            ->select('COUNT(nu.notification)')
            ->where('IDENTITY(nu.user) = :userId')
            ->andWhere('nu.isRead = false')
            ->setParameter('userId', $userId)
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function findByNotificationAndUser(int $notificationId, string $userId): ?NotificationsUsers
    {
        return $this->createQueryBuilder('nu')
            ->where('IDENTITY(nu.notification) = :notificationId')
            ->andWhere('IDENTITY(nu.user) = :userId')
            ->setParameter('notificationId', $notificationId)
            ->setParameter('userId', $userId)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * @return NotificationsUsers[]
     */
    public function findAllUnreadByUser(string $userId): array
    {
        return $this->createQueryBuilder('nu')
            ->where('IDENTITY(nu.user) = :userId')
            ->andWhere('nu.isRead = false')
            ->setParameter('userId', $userId)
            ->getQuery()
            ->getResult();
    }
}
