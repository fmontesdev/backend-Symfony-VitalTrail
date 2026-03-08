<?php

declare(strict_types=1);

namespace App\Sessions\Application\UseCase\Command\CreateSession;

use App\Routes\Application\Exception\RouteNotFoundException;
use App\Routes\Domain\OutputPort\RouteRepository;
use App\Security\Domain\Exception\UserIsNotAuthenticatedException;
use App\Sessions\Application\Dto\RouteSessionDto;
use App\Sessions\Application\Service\RouteSessionService;
use App\Sessions\Domain\Entity\RouteSession;
use App\Sessions\Domain\OutputPort\RouteSessionRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class CreateSessionCommandHandler
{
    public function __construct(
        private readonly RouteRepository $routeRepository,
        private readonly RouteSessionRepository $routeSessionRepository,
        private readonly RouteSessionService $routeSessionService,
    ) {
    }

    public function __invoke(CreateSessionCommand $command): RouteSessionDto
    {
        $user = $this->routeSessionService->getContextUser();
        if ($user === null) {
            throw new UserIsNotAuthenticatedException();
        }

        $route = $this->routeRepository->findById($command->idRoute);
        if ($route === null) {
            throw new RouteNotFoundException((string) $command->idRoute);
        }

        $session = new RouteSession();
        $session->setRoute($route);
        $session->setUser($user);

        if ($command->startAt !== null) {
            $session->setStartAt($command->startAt);
        }

        $this->routeSessionRepository->save($session);

        return $this->routeSessionService->toDto($session);
    }
}
