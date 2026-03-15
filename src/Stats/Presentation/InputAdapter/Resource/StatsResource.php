<?php

declare(strict_types=1);

namespace App\Stats\Presentation\InputAdapter\Resource;

use App\Stats\Application\Config\StatsConfig;
use App\Stats\Presentation\InputAdapter\Provider\StatsProvider;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiResource(
    operations: [
        new GetCollection(
            uriTemplate: '/stats',
            paginationEnabled: false,
            provider: StatsProvider::class,
            normalizationContext: [
                'groups' => [StatsConfig::OUTPUT],
            ],
            cacheHeaders: [
                'max_age' => 86400,
                'shared_max_age' => 86400,
                'public' => true,
            ],
        ),
    ],
)]
final class StatsResource
{
    #[Groups([StatsConfig::OUTPUT])]
    public int $totalRoutes = 0;

    #[Groups([StatsConfig::OUTPUT])]
    public int $totalCategories = 0;

    #[Groups([StatsConfig::OUTPUT])]
    public int $totalActiveUsers = 0;

    #[Groups([StatsConfig::OUTPUT])]
    public int $totalKm = 0;
}
