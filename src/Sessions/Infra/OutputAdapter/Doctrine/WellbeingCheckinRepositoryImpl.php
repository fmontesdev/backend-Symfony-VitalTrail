<?php

declare(strict_types=1);

namespace App\Sessions\Infra\OutputAdapter\Doctrine;

use App\Sessions\Domain\Entity\WellbeingCheckin;
use App\Sessions\Domain\OutputPort\WellbeingCheckinRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<WellbeingCheckin>
 *
 * @method WellbeingCheckin|null find($id, $lockMode = null, $lockVersion = null)
 * @method WellbeingCheckin|null findOneBy(array $criteria, array $orderBy = null)
 * @method WellbeingCheckin[]    findAll()
 * @method WellbeingCheckin[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
final class WellbeingCheckinRepositoryImpl extends ServiceEntityRepository implements WellbeingCheckinRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, WellbeingCheckin::class);
    }

    public function findById(int $idCheckin): ?WellbeingCheckin
    {
        return $this->find($idCheckin);
    }

    public function findBySession(int $idSession): ?WellbeingCheckin
    {
        return $this->findOneBy(['session' => $idSession]);
    }

    public function save(WellbeingCheckin $entity): void
    {
        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush();
    }

    public function remove(WellbeingCheckin $entity): void
    {
        $this->getEntityManager()->remove($entity);
        $this->getEntityManager()->flush();
    }
}
