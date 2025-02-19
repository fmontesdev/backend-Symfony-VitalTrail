<?php

declare(strict_types=1);

namespace App\Routes\Infra\OutputAdapter\Doctrine;

use App\Routes\Domain\Entity\ImageRoute;
use App\Routes\Domain\OutputPort\ImageRouteRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ImageRoute>
 *
 * @method ImageRoute|null find($id, $lockMode = null, $lockVersion = null)
 * @method ImageRoute|null findOneBy(array $criteria, array $orderBy = null)
 * @method ImageRoute|null findOneById(int $id)
 * @method ImageRoute[]    findOneByRoute(Route $route)
 * @method ImageRoute[]    findAll()
 * @method ImageRoute[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ImageRouteRepositoryImpl extends ServiceEntityRepository implements ImageRouteRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ImageRoute::class);
    }

    public function findById(int $idImg): ?ImageRoute
    {
        return $this->findOneByIdImg($idImg);
    }

    /**
     * Busca todas las imágenes que contiene una ruta específica
     *
     * @param int   $idRoute
     * @return array
     */
    public function findImagesByRoute(int $idRoute): array
    {
        $queryBuilder = $this->createQueryBuilder('i')
            ->select('i')
            ->where('i.route = :route')
            ->setParameter('route', $idRoute)
            ->orderBy('i.idImg', 'ASC');
        /** @var ImageRoute[] */
        $result = $queryBuilder->getQuery()->getResult();
        return $result;
    }

    public function save(ImageRoute $entity): void
    {
        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush();
    }

    public function remove(ImageRoute $entity): void
    {
        $this->getEntityManager()->remove($entity);
        $this->getEntityManager()->flush();
    }

    /**
     * Verifica qué imágenes ya existen en una ruta específica
     *
     * @param int   $idRoute
     * @param array $images
     * @return array
     */
    public function findExistingImagesInRoute(int $idRoute, array $images): array
    {
        $queryBuilder = $this->createQueryBuilder('i')
            ->select('i.imgRoute')
            ->where('i.idRoute = :idRoute')
            ->setParameter('idRoute', $idRoute)
            ->andWhere('i.imgRoute IN (:imagenesArray)')
            ->setParameter('imagenesArray', $images);

        // Devuelve solo los nombres de las imágenes que coinciden
        return array_map(
            fn($result) => $result['imgRoute'],
            $queryBuilder->getQuery()->getResult()
        );
    }
}
