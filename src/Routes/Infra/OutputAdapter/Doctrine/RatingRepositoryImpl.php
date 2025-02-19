<?php

declare(strict_types=1);

namespace App\Routes\Infra\OutputAdapter\Doctrine;

use App\Routes\Domain\Entity\Rating;
use App\Routes\Domain\OutputPort\RatingRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Rating>
 *
 * @method Rating|null find($id, $lockMode = null, $lockVersion = null)
 * @method Rating|null findOneBy(array $criteria, array $orderBy = null)
 * @method Rating|null findOneById(int $id)
 * @method Rating[]    findAll()
 * @method Rating[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RatingRepositoryImpl extends ServiceEntityRepository implements RatingRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Rating::class);
    }

    public function findById(int $idRating): ?Rating
    {
        return $this->findOneByIdRating($idRating);
    }

    /**
     * Busca todas las valoraciones que contiene una ruta específica
     *
     * @param int   $idRoute
     * @return array|null
     */
    public function findRatingsByRoute(int $idRoute): ?array
    {
        $queryBuilder = $this->createQueryBuilder('r')
            ->select('r')
            ->where('r.route = :route')
            ->setParameter('route', $idRoute)
            ->orderBy('r.createdAt', 'DESC');
        /** @var Rating[] */
        $result = $queryBuilder->getQuery()->getResult();
        return $result;
    }

    public function save(Rating $entity): void
    {
        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush();
    }

    public function remove(Rating $entity): void
    {
        $this->getEntityManager()->remove($entity);
        $this->getEntityManager()->flush();
    }

    public function averageRatings(int $idRoute): float
    {
        $queryBuilder = $this->createQueryBuilder('r')
            ->select('AVG(r.rating)')
            ->where('r.route = :route')
            ->setParameter('route', $idRoute);
        /** @var float */
        $result = $queryBuilder->getQuery()->getSingleScalarResult();
        return round((float) $result, 1); // Redondea a un decimal
    }
}
