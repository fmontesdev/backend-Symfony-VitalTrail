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
        $queryBuilder = $this->createQueryBuilder('r')
            ->select('r');
        if ($category !== null && trim($category) !== '') {
            $queryBuilder
                ->join('r.category', 'c', Join::WITH, 'LOWER(c.title) LIKE LOWER(:category)')
                ->setParameter('category', trim($category));
        }
        if ($location !== null && trim($location) !== '') {
            $queryBuilder
                ->andWhere('LOWER(r.location) LIKE LOWER(:location)')
                ->setParameter('location', trim($location));
        }
        if ($title !== null && trim($title) !== '') {
            $queryBuilder
                ->andWhere('LOWER(r.title) LIKE LOWER(:title)')
                ->setParameter('title', '%'.trim($title).'%');
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
        return $this->findOneBySlug($slug);
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
        ?string $author = null
    ): array {
        $queryBuilder = $this->createRoutesQueryBuilder($category, $location, $title, $distance, $difficulty, $typeRoute, $author);
        $queryBuilder
            ->select('r')
            ->orderBy('r.createdAt', 'DESC')
            ->setFirstResult($offset)
            ->setMaxResults($limit);
        /** @var Route[] */
        $result = $queryBuilder->getQuery()->getResult();
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
        $this->getEntityManager()->remove($entity);
        $this->getEntityManager()->flush();
    }
}
