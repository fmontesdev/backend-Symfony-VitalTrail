<?php

declare(strict_types=1);

namespace App\Auth\Domain\Entity;

use App\Auth\Infra\OutputAdapter\Doctrine\RefreshTokenRepositoryImpl;
// use App\Auth\Application\Config\RefreshTokenConfig;
// use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
// use App\Shared\Config\DotenvConfig as Dotenv;
use Gesdinet\JWTRefreshTokenBundle\Entity\RefreshToken as BaseRefreshToken;
// use Gesdinet\JWTRefreshTokenBundle\Model\RefreshTokenInterface;
// use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: RefreshTokenRepositoryImpl::class)]
#[ORM\Table(name: 'refresh_tokens')]
class RefreshToken extends BaseRefreshToken
// class RefreshToken implements RefreshTokenInterface
{
    // #[ORM\Id]
    // #[ORM\GeneratedValue]
    // #[ORM\Column(name: 'id_refresh', type: Types::BIGINT)]
    // private ?int $id = null;

    // #[ORM\Column(name: 'refresh_token', length: RefreshTokenConfig::TOKEN_LENGTH, unique: true)]
    // private ?string $refreshToken = null;

    // #[ORM\Column(length: RefreshTokenConfig::USERNAME_LENGTH, unique: true)]
    // private ?string $username = null;

    // #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    // private ?\DateTimeInterface $valid = null;

    // /**
    //  * Creates a new model instance based on the provided details.
    //  */
    // public static function createForUserWithTtl(string $refreshToken, UserInterface $user, int $ttl): RefreshTokenInterface
    // {
    //     $valid = new \DateTime();

    //     // Explicitly check for a negative number based on a behavior change in PHP 8.2, see https://github.com/php/php-src/issues/9950
    //     if ($ttl > 0) {
    //         $valid->modify('+'.$ttl.' seconds');
    //     } elseif ($ttl < 0) {
    //         $valid->modify($ttl.' seconds');
    //     }

    //     $model = new static();
    //     $model->setRefreshToken($refreshToken);
    //     $model->setUsername($user->getUserIdentifier());
    //     $model->setValid($valid);

    //     return $model;
    // }

    // /**
    //  * @return string Refresh Token
    //  */
    // public function __toString():   string
    // {
    //     return $this->getRefreshToken() ?: '';
    // }

    // /**
    //  * {@inheritdoc}
    //  */
    // public function getId()
    // {
    //     return $this->id;
    // }

    // /**
    //  * {@inheritdoc}
    //  */
    // public function setRefreshToken($refreshToken = null)
    // {
    //     if (null === $refreshToken || '' === $refreshToken) {
    //         trigger_deprecation('gesdinet/jwt-refresh-token-bundle', '1.0', 'Passing an empty token to %s() to automatically generate a token is deprecated.', __METHOD__);

    //         $refreshToken = bin2hex(random_bytes(64));
    //     }

    //     $this->refreshToken = $refreshToken;

    //     return $this;
    // }

    // /**
    //  * {@inheritdoc}
    //  */
    // public function getRefreshToken()
    // {
    //     return $this->refreshToken;
    // }

    // /**
    //  * {@inheritdoc}
    //  */
    // public function setValid($valid)
    // {
    //     $this->valid = $valid;

    //     return $this;
    // }

    // /**
    //  * {@inheritdoc}
    //  */
    // public function getValid()
    // {
    //     return $this->valid;
    // }

    // /**
    //  * {@inheritdoc}
    //  */
    // public function setUsername($username)
    // {
    //     $this->username = $username;

    //     return $this;
    // }

    // /**
    //  * {@inheritdoc}
    //  */
    // public function getUsername()
    // {
    //     return $this->username;
    // }

    // /**
    //  * {@inheritdoc}
    //  */
    // public function isValid()
    // {
    //     return null !== $this->valid && $this->valid >= new \DateTime();
    // }
}
