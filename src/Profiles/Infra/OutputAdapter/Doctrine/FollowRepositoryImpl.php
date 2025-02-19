<?php

declare(strict_types=1);

namespace App\Profiles\Infra\OutputAdapter\Doctrine;

use App\Profiles\Domain\Entity\Follow;
use App\Auth\Domain\Entity\User;
use App\Profiles\Domain\OutputPort\FollowRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Follow>
 *
 * @method Follow|null find($id, $lockMode = null, $lockVersion = null)
 * @method Follow|null findOneBy(array $criteria, array $orderBy = null)
 * @method Follow[]    findAll()
 * @method Follow[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @method int         countFollowers(User $followed)
 * @method int         countFolloweds(User $follower)
 */
class FollowRepositoryImpl extends ServiceEntityRepository implements FollowRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Follow::class);
    }

    public function exists(User $follower, User $followed): bool
    {
        return $this->find(['follower' => $follower,'followed' => $followed]) ? true : false;
    }

    public function add(User $follower, User $followed): void
    {
        if (!$this->exists($follower, $followed)) {
            $followEntity = new Follow();
            $followEntity->setFollower($follower);
            $followEntity->setFollowed($followed);
            $this->getEntityManager()->persist($followEntity);
            $this->getEntityManager()->flush();
        }
    }

    public function remove(User $follower, User $followed): void
    {
        $followEntity = $this->find(['follower' => $follower,'followed' => $followed]);
        if ($followEntity !== null) {
            $this->getEntityManager()->remove($followEntity);
            $this->getEntityManager()->flush();
        }
    }

    public function countFollowers(User $followed): int
    {
    return $this->count(['followed' => $followed]);
    }

    public function countFollowings(User $follower): int
    {
    return $this->count(['follower' => $follower]);
    }
}
