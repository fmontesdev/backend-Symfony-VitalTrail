<?php

declare(strict_types=1);

namespace App\Sessions\Application\Service;

use App\Auth\Domain\Entity\User;
use App\Security\Application\AuthorizationService;
use App\Security\Application\SecurityContext;
use App\Sessions\Application\Dto\RouteSessionDto;
use App\Sessions\Application\Exception\SessionNotFoundException;
use App\Sessions\Domain\Entity\RouteSession;
use App\Sessions\Domain\OutputPort\RouteSessionRepository;
use App\Sessions\Presentation\Mapper\RouteSessionMapper;

final class RouteSessionService
{
    public function __construct(
        private readonly RouteSessionRepository $routeSessionRepository,
        private readonly RouteSessionMapper $routeSessionMapper,
        private readonly SecurityContext $securityContext,
        private readonly AuthorizationService $authorizationService,
    ) {
    }

    public function getContextUser(): ?User
    {
        return $this->securityContext->getAuthenticatedUser();
    }

    public function findSessionSafe(int $idSession): RouteSession
    {
        $session = $this->routeSessionRepository->findById($idSession);
        if ($session === null) {
            throw new SessionNotFoundException($idSession);
        }
        return $session;
    }

    public function isAuthorized(RouteSession $session): bool
    {
        return $this->authorizationService->isOwner($session);
    }

    public function toDto(RouteSession $session): RouteSessionDto
    {
        return $this->routeSessionMapper->mapEntityToDto($session);
    }
}
