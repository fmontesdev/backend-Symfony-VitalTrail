<?php

declare(strict_types=1);

namespace App\Notifications\Infra\OutputAdapter\Doctrine;

use App\Notifications\Domain\Entity\Notification;
use App\Notifications\Domain\OutputPort\NotificationRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Notification>
 *
 * @method Notification|null find($id, $lockMode = null, $lockVersion = null)
 * @method Notification|null findOneBy(array $criteria, array $orderBy = null)
 * @method Notification[]    findAll()
 * @method Notification[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NotificationRepositoryImpl extends ServiceEntityRepository implements NotificationRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Notification::class);
    }

    public function save(Notification $notification): void
    {
        $this->getEntityManager()->persist($notification);
        $this->getEntityManager()->flush();
    }

    public function findById(int $id): ?Notification
    {
        return $this->find($id);
    }

    public function delete(Notification $notification): void
    {
        $this->getEntityManager()->remove($notification);
        $this->getEntityManager()->flush();
    }
}
