<?php

declare(strict_types=1);

namespace App\Stats\Application\UseCase\Query\GetPlatformStats;

use App\Auth\Domain\OutputPort\UserRepository;
use App\Routes\Domain\OutputPort\CategoryRouteRepository;
use App\Routes\Domain\OutputPort\RouteRepository;
use App\Stats\Application\Dto\StatsDto;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class GetPlatformStatsQueryHandler
{
    public function __construct(
        private readonly RouteRepository $routeRepository,
        private readonly CategoryRouteRepository $categoryRouteRepository,
        private readonly UserRepository $userRepository,
    ) {
    }

    public function __invoke(GetPlatformStatsQuery $query): StatsDto
    {
        return new StatsDto(
            totalRoutes: $this->routeRepository->countRoutes(null, null, null, null, null, null, null),
            totalCategories: $this->categoryRouteRepository->countAllCategories(),
            totalActiveUsers: $this->userRepository->countActiveClients(),
            totalKm: $this->routeRepository->sumAllDistances(),
        );
    }
}
