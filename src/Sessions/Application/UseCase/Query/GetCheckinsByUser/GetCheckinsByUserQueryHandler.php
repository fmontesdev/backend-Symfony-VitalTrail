<?php

declare(strict_types=1);

namespace App\Sessions\Application\UseCase\Query\GetCheckinsByUser;

use App\Security\Domain\Exception\UserIsNotAuthenticatedException;
use App\Sessions\Application\Dto\WellbeingCheckinDto;
use App\Sessions\Application\Service\RouteSessionService;
use App\Sessions\Application\Service\WellbeingCheckinService;
use App\Sessions\Domain\Entity\WellbeingCheckin;
use App\Sessions\Domain\OutputPort\WellbeingCheckinRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class GetCheckinsByUserQueryHandler
{
    public function __construct(
        private readonly RouteSessionService $routeSessionService,
        private readonly WellbeingCheckinRepository $wellbeingCheckinRepository,
        private readonly WellbeingCheckinService $wellbeingCheckinService,
    ) {
    }

    /**
     * @return WellbeingCheckinDto[]
     */
    public function __invoke(GetCheckinsByUserQuery $query): array
    {
        $user = $this->routeSessionService->getContextUser();
        if ($user === null) {
            throw new UserIsNotAuthenticatedException();
        }

        $checkins = $this->wellbeingCheckinRepository->findByUser($user->getIdUser());

        return array_map(
            fn (WellbeingCheckin $checkin) => $this->wellbeingCheckinService->toDto($checkin),
            $checkins,
        );
    }
}
