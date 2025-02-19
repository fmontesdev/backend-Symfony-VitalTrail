<?php

declare(strict_types=1);

namespace App\Routes\Infra\OutputAdapter\Doctrine;

use App\Routes\Domain\Entity\Comment;
use App\Routes\Domain\OutputPort\CommentRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Uid\Uuid;

/**
 * @extends ServiceEntityRepository<Comment>
 *
 * @method Comment|null find($id, $lockMode = null, $lockVersion = null)
 * @method Comment|null findOneBy(array $criteria, array $orderBy = null)
 * @method Comment|null findOneById(int $id)
 * @method Comment[]    findAll()
 * @method Comment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommentRepositoryImpl extends ServiceEntityRepository implements CommentRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Comment::class);
    }

    public function findById(int $idComment): ?Comment
    {
        return $this->findOneByIdComment($idComment);
    }

    /**
     * Busca todos las comentarios que contiene una ruta específica
     *
     * @param int   $idRoute
     * @return array|null
     */
    public function findCommentsByRoute(int $idRoute): ?array
    {
        $queryBuilder = $this->createQueryBuilder('c')
            ->select('c')
            ->where('c.route = :route')
            ->setParameter('route', $idRoute)
            ->orderBy('c.createdAt', 'DESC');
        /** @var Comment[] */
        $result = $queryBuilder->getQuery()->getResult();
        return $result;
    }

    /**
     * Busca todos las comentarios que contiene una ruta específica
     *
     * @param Uuid   $idUser
     * @return array|null
     */
    public function findCommentsByUser(Uuid $idUser): ?array
    {
        $queryBuilder = $this->createQueryBuilder('c')
            ->select('c')
            ->where('c.user = :user')
            ->setParameter('user', $idUser)
            ->orderBy('c.createdAt', 'DESC');
        /** @var Comment[] */
        $result = $queryBuilder->getQuery()->getResult();
        return $result;
    }

    public function save(Comment $entity): void
    {
        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush();
    }

    public function remove(Comment $entity): void
    {
        $this->getEntityManager()->remove($entity);
        $this->getEntityManager()->flush();
    }
}
