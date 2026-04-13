<?php

declare(strict_types=1);

namespace App\Routes\Infra\OutputAdapter\Doctrine;

use App\Routes\Domain\Entity\Route;
use App\Routes\Domain\OutputPort\RouteRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Route>
 *
 * @method Route|null find($id, $lockMode = null, $lockVersion = null)
 * @method Route|null findOneBy(array $criteria, array $orderBy = null)
 * @method Route|null findOneByIdRoute(int $idRoute)
 * @method Route|null findOneBySlug(string $slug)
 * @method Route[]    findAll()
 * @method Route[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RouteRepositoryImpl extends ServiceEntityRepository implements RouteRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Route::class);
    }

    private function createRoutesQueryBuilder(
        ?string $category = null,
        ?string $location = null,
        ?string $title = null,
        ?int $distance = null,
        ?string $difficulty = null,
        ?string $typeRoute = null,
        ?string $author = null
    ): QueryBuilder {
        $normalizedLocation = $location !== null ? trim($location) : null;
        $normalizedTitle = $title !== null ? trim($title) : null;

        $queryBuilder = $this->createQueryBuilder('r')
            ->select('r')
            ->andWhere('r.isActive = true');
        if ($category !== null && trim($category) !== '') {
            $queryBuilder
                ->join('r.category', 'c', Join::WITH, 'LOWER(c.title) LIKE LOWER(:category)')
                ->setParameter('category', trim($category));
        }

        if ($normalizedLocation !== null && '' !== $normalizedLocation && $normalizedTitle !== null && '' !== $normalizedTitle) {
            $queryBuilder
                ->andWhere('(LOWER(r.location) LIKE LOWER(:location) OR LOWER(r.title) LIKE LOWER(:title))')
                ->setParameter('location', '%'.$normalizedLocation.'%')
                ->setParameter('title', '%'.$normalizedTitle.'%');
        } elseif ($normalizedLocation !== null && '' !== $normalizedLocation) {
            $queryBuilder
                ->andWhere('LOWER(r.location) LIKE LOWER(:location)')
                ->setParameter('location', '%'.$normalizedLocation.'%');
        } elseif ($normalizedTitle !== null && '' !== $normalizedTitle) {
            $queryBuilder
                ->andWhere('LOWER(r.title) LIKE LOWER(:title)')
                ->setParameter('title', '%'.$normalizedTitle.'%');
        }
        if ($distance !== null && $distance > 0) {
            $queryBuilder
                ->andWhere('r.distance <= :distance')
                ->setParameter('distance', $distance);
        }
        if ($difficulty !== null && trim($difficulty) !== '') {
            $queryBuilder
                ->andWhere('LOWER(r.difficulty) LIKE LOWER(:difficulty)')
                ->setParameter('difficulty', trim($difficulty));
        }
        if ($typeRoute !== null && trim($typeRoute) !== '') {
            $queryBuilder
                ->andWhere('LOWER(r.typeRoute) LIKE LOWER(:typeRoute)')
                ->setParameter('typeRoute', trim($typeRoute));
        }
        if ($author !== null && trim($author) !== '') {
            $queryBuilder
                ->join('r.user', 'u', Join::WITH, 'u.username LIKE :author')
                ->setParameter('author', trim($author));
        }
        return $queryBuilder;
    }

    public function findById(int $idRoute): ?Route
    {
        return $this->findOneByIdRoute($idRoute);
    }

    public function findBySlug(string $slug): ?Route
    {
        return $this->createQueryBuilder('r')
            ->where('r.slug = :slug')
            ->andWhere('r.isActive = true')
            ->setParameter('slug', $slug)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * @param integer $limit
     * @param integer $offset
     * @param string|null $title
     * @param integer|null $distance
     * @param string|null $difficulty
     * @param string|null $typeRoute
     * @return Route[]
     */
    public function findAllRoutes(
        int $limit,
        int $offset,
        ?string $category = null,
        ?string $location = null,
        ?string $title = null,
        ?int $distance = null,
        ?string $difficulty = null,
        ?string $typeRoute = null,
        ?string $author = null,
        ?string $sortBy = null,
        ?string $order = null,
    ): array {
        $qb = $this->createRoutesQueryBuilder($category, $location, $title, $distance, $difficulty, $typeRoute, $author);

        if ($sortBy === 'favoritesCount') {
            $qb->addSelect(
                '(SELECT COUNT(IDENTITY(fav.route)) FROM App\Routes\Domain\Entity\Favorite fav WHERE fav.route = r) AS HIDDEN favoritesCount'
            );
        }

        $resolvedSortBy = $sortBy ?? 'createdAt';
        $resolvedOrder  = strtoupper($order ?? 'desc');

        if ($resolvedSortBy === 'favoritesCount') {
            $qb->orderBy('favoritesCount', $resolvedOrder);
        } else {
            $fieldMap = [
                'createdAt' => 'r.createdAt',
                'title'     => 'r.title',
                'distance'  => 'r.distance',
            ];
            $dbField = $fieldMap[$resolvedSortBy] ?? 'r.createdAt';
            $qb->orderBy($dbField, $resolvedOrder);
        }

        $qb->setFirstResult($offset)
            ->setMaxResults($limit);

        /** @var Route[] */
        $result = $qb->getQuery()->getResult();
        return $result;
    }

    public function countRoutes(
        ?string $category = null,
        ?string $location = null,
        ?string $title = null,
        ?int $distance = null,
        ?string $difficulty = null,
        ?string $typeRoute = null,
        ?string $author = null
    ): int {
        $queryBuilder = $this->createRoutesQueryBuilder($category, $location, $title, $distance, $difficulty, $typeRoute, $author);
        $queryBuilder->select('COUNT(r)');
        /** @var int */
        $result = $queryBuilder->getQuery()->getSingleScalarResult();
        return $result;
    }

    public function save(Route $entity): void
    {
        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush();
    }

    public function remove(Route $entity): void
    {
        $entity->setIsActive(false);
        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush();
    }

    public function sumAllDistances(): int
    {
        return (int) $this->createQueryBuilder('r')
            ->select('COALESCE(SUM(r.distance), 0)')
            ->where('r.isActive = true')
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function countNewRoutesThisMonth(): int
    {
        $start = new \DateTime('first day of this month midnight');

        return (int) $this->createQueryBuilder('r')
            ->select('COUNT(r.idRoute)')
            ->where('r.createdAt >= :start')
            ->andWhere('r.isActive = true')
            ->setParameter('start', $start)
            ->getQuery()
            ->getSingleScalarResult();
    }

    /**
     * @return array<array{month: string, newRoutes: int}>
     */
    public function getRoutesGrowthByMonth(int $months): array
    {
        $conn = $this->getEntityManager()->getConnection();
        $rows = $conn->fetchAllAssociative(
            "SELECT TO_CHAR(r.create_at, 'YYYY-MM') AS month,
                    COUNT(r.id_route) AS new_routes
             FROM routes r
             WHERE r.create_at >= DATE_TRUNC('month', NOW()) - (:months || ' months')::INTERVAL
               AND r.is_active = true
             GROUP BY month
             ORDER BY month DESC",
            ['months' => $months],
        );

        return array_map(
            static fn(array $row): array => [
                'month' => (string) $row['month'],
                'newRoutes' => (int) $row['new_routes'],
            ],
            $rows,
        );
    }
}
