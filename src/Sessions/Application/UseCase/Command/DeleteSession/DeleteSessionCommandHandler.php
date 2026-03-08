<?php

declare(strict_types=1);

namespace App\Sessions\Application\UseCase\Command\DeleteSession;

use App\Security\Domain\Exception\NotAuthorizedResourceException;
use App\Sessions\Application\Service\RouteSessionService;
use App\Sessions\Domain\OutputPort\RouteSessionRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class DeleteSessionCommandHandler
{
    public function __construct(
        private readonly RouteSessionService $routeSessionService,
        private readonly RouteSessionRepository $routeSessionRepository,
    ) {
    }

    public function __invoke(DeleteSessionCommand $command): void
    {
        $session = $this->routeSessionService->findSessionSafe($command->idSession);

        if (!$this->routeSessionService->isAuthorized($session)) {
            throw new NotAuthorizedResourceException();
        }

        $this->routeSessionRepository->remove($session);
    }
}
