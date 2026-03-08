<?php

declare(strict_types=1);

namespace App\Sessions\Application\UseCase\Query\GetSessionsByUser;

use App\Security\Domain\Exception\UserIsNotAuthenticatedException;
use App\Sessions\Application\Dto\RouteSessionDto;
use App\Sessions\Application\Service\RouteSessionService;
use App\Sessions\Domain\Entity\RouteSession;
use App\Sessions\Domain\OutputPort\RouteSessionRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class GetSessionsByUserQueryHandler
{
    public function __construct(
        private readonly RouteSessionService $routeSessionService,
        private readonly RouteSessionRepository $routeSessionRepository,
    ) {
    }

    /**
     * @return RouteSessionDto[]
     */
    public function __invoke(GetSessionsByUserQuery $query): array
    {
        $user = $this->routeSessionService->getContextUser();
        if ($user === null) {
            throw new UserIsNotAuthenticatedException();
        }

        $sessions = $this->routeSessionRepository->findByUser($user->getIdUser());

        return array_map(
            fn (RouteSession $session) => $this->routeSessionService->toDto($session),
            $sessions,
        );
    }
}
