<?php

declare(strict_types=1);

namespace App\Routes\Infra\OutputAdapter\Doctrine;

use App\Routes\Domain\Entity\Favorite;
use App\Routes\Domain\Entity\Route;
use App\Auth\Domain\Entity\User;
use App\Routes\Domain\OutputPort\FavoriteRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Favorite>
 *
 * @method Favorite|null find($id, $lockMode = null, $lockVersion = null)
 * @method Favorite|null findOneBy(array $criteria, array $orderBy = null)
 * @method Favorite[]    findAll()
 * @method Favorite[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @method int           countByRoute(Route $route)
 */
class FavoriteRepositoryImpl extends ServiceEntityRepository implements FavoriteRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Favorite::class);
    }

    public function exists(Route $route, User $user): bool
    {
        return $this->find(['route' => $route,'user' => $user,]) ? true : false;
    }

    public function add(Route $route, User $user): void
    {
        if (!$this->exists($route, $user)) {
            $favoriteEntity = new Favorite();
            $favoriteEntity->setRoute($route);
            $favoriteEntity->setUser($user);
            $this->getEntityManager()->persist($favoriteEntity);
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Route $route, User $user): void
    {
        $favoriteEntity = $this->find(['route' => $route,'user' => $user,]);
        if ($favoriteEntity !== null) {
            $this->getEntityManager()->remove($favoriteEntity);
            $this->getEntityManager()->flush();
        }
    }

    public function countByRoute(Route $route): int
    {
    return $this->count(['route' => $route,]);
    }
}
