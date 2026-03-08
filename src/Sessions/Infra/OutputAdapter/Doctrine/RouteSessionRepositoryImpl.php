<?php

declare(strict_types=1);

namespace App\Sessions\Infra\OutputAdapter\Doctrine;

use App\Sessions\Domain\Entity\RouteSession;
use App\Sessions\Domain\OutputPort\RouteSessionRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Uid\Uuid;

/**
 * @extends ServiceEntityRepository<RouteSession>
 *
 * @method RouteSession|null find($id, $lockMode = null, $lockVersion = null)
 * @method RouteSession|null findOneBy(array $criteria, array $orderBy = null)
 * @method RouteSession[]    findAll()
 * @method RouteSession[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
final class RouteSessionRepositoryImpl extends ServiceEntityRepository implements RouteSessionRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RouteSession::class);
    }

    public function findById(int $idSession): ?RouteSession
    {
        return $this->find($idSession);
    }

    public function findByUser(Uuid $idUser): array
    {
        return $this->createQueryBuilder('rs')
            ->where('rs.user = :idUser')
            ->setParameter('idUser', $idUser)
            ->orderBy('rs.startAt', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function findByRoute(int $idRoute): array
    {
        return $this->createQueryBuilder('rs')
            ->where('rs.route = :idRoute')
            ->setParameter('idRoute', $idRoute)
            ->orderBy('rs.startAt', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function save(RouteSession $entity): void
    {
        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush();
    }

    public function remove(RouteSession $entity): void
    {
        $this->getEntityManager()->remove($entity);
        $this->getEntityManager()->flush();
    }
}
