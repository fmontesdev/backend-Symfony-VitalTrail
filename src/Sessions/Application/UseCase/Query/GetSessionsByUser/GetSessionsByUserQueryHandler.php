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
class GetSessionsByUserQueryHandler
{
    public function __construct(
        private readonly RouteSessionService $routeSessionService,
        private readonly RouteSessionRepository $routeSessionRepository,
    ) {
    }

    /**
     * @return array{sessions: RouteSessionDto[], count: int}
     */
    public function __invoke(GetSessionsByUserQuery $query): array
    {
        $user = $this->routeSessionService->getContextUser();
        if ($user === null) {
            throw new UserIsNotAuthenticatedException();
        }

        $userId = $user->getIdUser();
        $count = $this->routeSessionRepository->countClosedByUser($userId);
        $sessions = $count > 0
            ? $this->routeSessionRepository->findClosedByUser($userId, $query->limit, $query->offset)
            : [];

        return [
            'sessions' => array_map(
                fn (RouteSession $session) => $this->routeSessionService->toDto($session),
                $sessions,
            ),
            'count' => $count,
        ];
    }
}
