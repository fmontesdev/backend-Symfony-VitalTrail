<?php

declare(strict_types=1);

namespace App\Admin\Presentation\Mapper;

use App\Admin\Application\Dto\AdminStatsDto;
use App\Admin\Application\Dto\RouteGrowthPointDto;
use App\Admin\Application\Dto\UserGrowthPointDto;
use App\Admin\Presentation\InputAdapter\Resource\AdminStatsResource;
use App\Admin\Presentation\InputAdapter\Resource\RouteGrowthPointResource;
use App\Admin\Presentation\InputAdapter\Resource\UserGrowthPointResource;

final class AdminStatsMapper
{
    public static function mapDtoToResource(AdminStatsDto $dto): AdminStatsResource
    {
        $resource = new AdminStatsResource();
        $resource->users = [
            'total' => $dto->users->total,
            'newThisMonth' => $dto->users->newThisMonth,
            'premium' => $dto->users->premium,
            'free' => $dto->users->free,
            'conversionRate' => $dto->users->conversionRate,
        ];
        $resource->routes = [
            'total' => $dto->routes->total,
            'newThisMonth' => $dto->routes->newThisMonth,
        ];
        $resource->sessions = [
            'total' => $dto->sessions->total,
            'thisMonth' => $dto->sessions->thisMonth,
            'totalKm' => $dto->sessions->totalKm,
        ];

        return $resource;
    }

    public static function mapUserGrowthDtoToResource(UserGrowthPointDto $dto): UserGrowthPointResource
    {
        $resource = new UserGrowthPointResource();
        $resource->month = $dto->month;
        $resource->newUsers = $dto->newUsers;
        $resource->newPremium = $dto->newPremium;

        return $resource;
    }

    public static function mapRouteGrowthDtoToResource(RouteGrowthPointDto $dto): RouteGrowthPointResource
    {
        $resource = new RouteGrowthPointResource();
        $resource->month = $dto->month;
        $resource->newRoutes = $dto->newRoutes;

        return $resource;
    }
}
