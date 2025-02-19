<?php

declare(strict_types=1);

namespace App\Security\Application;

use App\Auth\Domain\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class SecurityContext
{
    public function __construct(
        private TokenStorageInterface $tokenStorage,
    ) {  
    }

    public function isAuthenticated(): bool
    {
        return $this->tokenStorage->getToken() !== null;
    }

    public function getAuthenticatedUser(): ?User
    {
        $token = $this->tokenStorage->getToken();
        if ($token === null) return null;
        return $token->getUser();
    }

    public function getRoles(): array
    {
        $token = $this->tokenStorage->getToken();
        return $token ? $token->getRoleNames() : null;
    }

    public function isAdmin(): bool
    {
        return $this->getRoles() === ['ROLE_ADMIN'] ? true : false;
    }
}
