<?php

declare(strict_types=1);

namespace App\Stats\Presentation\Mapper;

use App\Stats\Application\Dto\StatsDto;
use App\Stats\Presentation\InputAdapter\Resource\StatsResource;

final class StatsMapper
{
    public static function mapDtoToResource(StatsDto $dto): StatsResource
    {
        $resource = new StatsResource();
        $resource->totalRoutes = $dto->totalRoutes;
        $resource->totalCategories = $dto->totalCategories;
        $resource->totalActiveUsers = $dto->totalActiveUsers;
        $resource->totalKm = $dto->totalKm;

        return $resource;
    }
}
