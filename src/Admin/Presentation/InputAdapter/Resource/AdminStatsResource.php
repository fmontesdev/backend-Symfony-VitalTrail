<?php

declare(strict_types=1);

namespace App\Admin\Presentation\InputAdapter\Resource;

use App\Admin\Application\Config\AdminConfig;
use App\Admin\Presentation\InputAdapter\Provider\AdminStatsProvider;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiResource(
    operations: [
        new GetCollection(
            uriTemplate: '/admin/stats',
            paginationEnabled: false,
            provider: AdminStatsProvider::class,
            normalizationContext: [
                'groups' => [AdminConfig::STATS_OUTPUT],
            ],
            security: 'is_granted("ROLE_ADMIN")',
        ),
    ],
)]
final class AdminStatsResource
{
    #[Groups([AdminConfig::STATS_OUTPUT])]
    public array $users = [];

    #[Groups([AdminConfig::STATS_OUTPUT])]
    public array $routes = [];

    #[Groups([AdminConfig::STATS_OUTPUT])]
    public array $sessions = [];
}
