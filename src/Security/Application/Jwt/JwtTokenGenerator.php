<?php

declare(strict_types=1);

namespace App\Security\Application\Jwt;

use App\Auth\Domain\Entity\User;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Gesdinet\JWTRefreshTokenBundle\Model\RefreshTokenManagerInterface;

class JwtTokenGenerator
{
    public function __construct(
        private JWTTokenManagerInterface $tokenManager,
        private RefreshTokenManagerInterface $refreshTokenManager,
    ) {
    }

    public function createAccessToken(User $user): string 
    {
        $token = $this->tokenManager->create($user);
        return $token;
    }

    public function createRefreshToken(User $user): string 
    {
        $refreshToken = $this->refreshTokenManager->create();
        $refreshToken->setUsername($user->getUsername());
        $refreshToken->setRefreshToken();
        $refreshToken->setValid((new \DateTime())->modify('+1 month'));
        $this->refreshTokenManager->save($refreshToken);

        return $refreshToken->getRefreshToken();
    }
}