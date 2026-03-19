<?php

declare(strict_types=1);

namespace App\Sessions\Application\UseCase\Command\CloseSession;

use App\Security\Domain\Exception\NotAuthorizedResourceException;
use App\Sessions\Application\Dto\RouteSessionDto;
use App\Sessions\Application\Service\RouteSessionService;
use App\Sessions\Domain\OutputPort\RouteSessionRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class CloseSessionCommandHandler
{
    public function __construct(
        private readonly RouteSessionService $routeSessionService,
        private readonly RouteSessionRepository $routeSessionRepository,
    ) {
    }

    public function __invoke(CloseSessionCommand $command): RouteSessionDto
    {
        $session = $this->routeSessionService->findSessionSafe($command->idSession);

        if (!$this->routeSessionService->isAuthorized($session)) {
            throw new NotAuthorizedResourceException();
        }

        $session->setEndAt($command->endAt);
        $this->routeSessionRepository->save($session);

        return $this->routeSessionService->toDto($session);
    }
}
