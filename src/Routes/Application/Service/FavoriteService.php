<?php

declare(strict_types=1);

namespace App\Routes\Application\Service;

use App\Routes\Domain\Entity\Route;
use App\Routes\Domain\OutputPort\FavoriteRepository;
use App\Security\Application\SecurityContext;

class FavoriteService
{
    public function __construct(
        private readonly FavoriteRepository $favoriteRepository,
        private readonly SecurityContext $securityContext,
    ) {
    }

    public function isFavorited(Route $route): bool
    {
        $result = false;
        $user = $this->securityContext->getAuthenticatedUser();
        if ($user !== null) {
            $result = $this->favoriteRepository->exists($route, $user);
        }
        return $result;
    }

    public function  favoriteCount(Route $entity): int
    {
        return $this->favoriteRepository->countByRoute($entity);
    }
}