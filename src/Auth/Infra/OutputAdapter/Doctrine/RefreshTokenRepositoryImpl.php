<?php

declare(strict_types=1);

namespace App\Auth\Infra\OutputAdapter\Doctrine;

use App\Auth\Domain\Entity\RefreshToken;
use App\Auth\Domain\OutputPort\RefreshTokenRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Gesdinet\JWTRefreshTokenBundle\Doctrine\RefreshTokenRepositoryInterface;

/**
 * @extends ServiceEntityRepository<RefreshToken>
 *
 * @method RefreshToken|null find($id, $lockMode = null, $lockVersion = null)
 * @method RefreshToken|null findOneBy(array $criteria, array $orderBy = null)
 * @method RefreshToken|null findOneByUsername(string $username)
 * @method RefreshToken|null findOneByRefreshToken(string $refreshToken)
 * @method RefreshToken[]    findAll()
 * @method RefreshToken[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RefreshTokenRepositoryImpl extends ServiceEntityRepository implements RefreshTokenRepository, RefreshTokenRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RefreshToken::class);
    }

    public function findByUsername(string $username): ?RefreshToken
    {
        return $this->findOneByEmail($username);
    }

    public function findByRefreshToken(string $refreshToken): ?RefreshToken
    {
        return $this->findOneByRefreshToken($refreshToken);
    }

    public function save(RefreshToken $refreshToken): void
    {
        $this->getEntityManager()->persist($refreshToken);
        $this->getEntityManager()->flush();
    }

    public function findInvalid($datetime = null): array
    {
        $datetime = $datetime ?? new \DateTime();
        return $this->createQueryBuilder('rt')
            ->where('rt.valid <= :datetime')
            ->setParameter('datetime', $datetime)
            ->getQuery()
            ->getResult();
    }
}
