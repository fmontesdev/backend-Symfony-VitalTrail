<?php

declare(strict_types=1);

namespace App\Routes\Infra\OutputAdapter\Doctrine;

use App\Routes\Domain\Entity\CategoryRoute;
use App\Routes\Domain\OutputPort\CategoryRouteRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
// use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CategoryRoute>
 *
 * @method CategoryRoute|null find($id, $lockMode = null, $lockVersion = null)
 * @method CategoryRoute|null findOneBy(array $criteria, array $orderBy = null)
 * @method CategoryRoute|null findOneByTitle(string $title)
 * @method CategoryRoute[]    findAll()
 * @method CategoryRoute[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoryRouteRepositoryImpl extends ServiceEntityRepository implements CategoryRouteRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CategoryRoute::class);
    }

    public function findByTitle(string $title): ?CategoryRoute
    {
        return $this->findOneByTitle($title);
    }

    public function findAllCategoryRoutes(): array {
        return $this->findAll();
    }
}
