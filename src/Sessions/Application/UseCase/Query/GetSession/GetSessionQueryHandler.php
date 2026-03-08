<?php

declare(strict_types=1);

namespace App\Sessions\Application\UseCase\Query\GetSession;

use App\Security\Domain\Exception\NotAuthorizedResourceException;
use App\Sessions\Application\Dto\RouteSessionDto;
use App\Sessions\Application\Service\RouteSessionService;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class GetSessionQueryHandler
{
    public function __construct(
        private readonly RouteSessionService $routeSessionService,
    ) {
    }

    public function __invoke(GetSessionQuery $query): RouteSessionDto
    {
        $session = $this->routeSessionService->findSessionSafe($query->idSession);

        if (!$this->routeSessionService->isAuthorized($session)) {
            throw new NotAuthorizedResourceException();
        }

        return $this->routeSessionService->toDto($session);
    }
}
