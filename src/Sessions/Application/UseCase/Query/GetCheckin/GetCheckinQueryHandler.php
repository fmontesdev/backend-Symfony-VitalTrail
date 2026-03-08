<?php

declare(strict_types=1);

namespace App\Sessions\Application\UseCase\Query\GetCheckin;

use App\Security\Domain\Exception\NotAuthorizedResourceException;
use App\Sessions\Application\Dto\WellbeingCheckinDto;
use App\Sessions\Application\Service\RouteSessionService;
use App\Sessions\Application\Service\WellbeingCheckinService;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class GetCheckinQueryHandler
{
    public function __construct(
        private readonly RouteSessionService $routeSessionService,
        private readonly WellbeingCheckinService $wellbeingCheckinService,
    ) {
    }

    public function __invoke(GetCheckinQuery $query): WellbeingCheckinDto
    {
        $session = $this->routeSessionService->findSessionSafe($query->idSession);

        if (!$this->routeSessionService->isAuthorized($session)) {
            throw new NotAuthorizedResourceException();
        }

        $checkin = $this->wellbeingCheckinService->findCheckinBySessionSafe($query->idSession);

        return $this->wellbeingCheckinService->toDto($checkin);
    }
}
