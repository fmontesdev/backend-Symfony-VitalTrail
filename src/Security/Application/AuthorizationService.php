<?php

declare(strict_types=1);

namespace App\Security\Application;

use App\Security\Application\SecurityContext;

class AuthorizationService
{
    public function __construct(
        private SecurityContext $securityContext,
    ) {
    }

    public function isOwner(object $entity): bool
    {
        $currentUser = $this->securityContext->getAuthenticatedUser();
        return $currentUser->getIdUser() !== $entity->getUser()->getIdUser() ? false : true;
    }
} 