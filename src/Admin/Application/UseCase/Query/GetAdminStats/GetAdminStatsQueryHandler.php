<?php

declare(strict_types=1);

namespace App\Admin\Application\UseCase\Query\GetAdminStats;

use App\Admin\Application\Dto\AdminRoutesStatsDto;
use App\Admin\Application\Dto\AdminSessionsStatsDto;
use App\Admin\Application\Dto\AdminStatsDto;
use App\Admin\Application\Dto\AdminUsersStatsDto;
use App\Auth\Domain\OutputPort\UserRepository;
use App\Routes\Domain\OutputPort\RouteRepository;
use App\Sessions\Domain\OutputPort\RouteSessionRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class GetAdminStatsQueryHandler
{
    public function __construct(
        private UserRepository $userRepository,
        private RouteRepository $routeRepository,
        private RouteSessionRepository $routeSessionRepository,
    ) {
    }

    public function __invoke(GetAdminStatsQuery $query): AdminStatsDto
    {
        $totalUsers = $this->userRepository->countTotalUsers();
        $premiumUsers = $this->userRepository->countPremiumUsers();
        $freeUsers = $totalUsers - $premiumUsers;
        $conversionRate = $totalUsers > 0 ? round(($premiumUsers / $totalUsers) * 100, 1) : 0.0;

        $totalRoutes = $this->routeRepository->countRoutes();
        $newRoutesThisMonth = $this->routeRepository->countNewRoutesThisMonth();

        $totalSessions = $this->routeSessionRepository->countTotalSessions();
        $sessionsThisMonth = $this->routeSessionRepository->countSessionsThisMonth();
        $totalDistanceMeters = $this->routeSessionRepository->sumTotalDistanceMeters();
        $totalKm = (int) round($totalDistanceMeters / 1000);

        return new AdminStatsDto(
            users: new AdminUsersStatsDto(
                total: $totalUsers,
                newThisMonth: $this->userRepository->countNewUsersThisMonth(),
                premium: $premiumUsers,
                free: $freeUsers,
                conversionRate: $conversionRate,
            ),
            routes: new AdminRoutesStatsDto(
                total: $totalRoutes,
                newThisMonth: $newRoutesThisMonth,
            ),
            sessions: new AdminSessionsStatsDto(
                total: $totalSessions,
                thisMonth: $sessionsThisMonth,
                totalKm: $totalKm,
            ),
        );
    }
}
