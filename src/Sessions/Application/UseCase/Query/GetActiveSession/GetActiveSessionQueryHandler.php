<?php

declare(strict_types=1);

namespace App\Sessions\Application\UseCase\Query\GetActiveSession;

use App\Security\Domain\Exception\UserIsNotAuthenticatedException;
use App\Sessions\Application\Dto\RouteSessionDto;
use App\Sessions\Application\Exception\ActiveSessionNotFoundException;
use App\Sessions\Application\Service\RouteSessionService;
use App\Sessions\Domain\OutputPort\RouteSessionRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class GetActiveSessionQueryHandler
{
    public function __construct(
        private readonly RouteSessionService $routeSessionService,
        private readonly RouteSessionRepository $routeSessionRepository,
    ) {
    }

    public function __invoke(GetActiveSessionQuery $query): RouteSessionDto
    {
        $user = $this->routeSessionService->getContextUser();
        if ($user === null) {
            throw new UserIsNotAuthenticatedException();
        }

        $session = $this->routeSessionRepository->findActiveByUser($user->getIdUser());
        if ($session === null) {
            throw new ActiveSessionNotFoundException();
        }

        return $this->routeSessionService->toDto($session);
    }
}
