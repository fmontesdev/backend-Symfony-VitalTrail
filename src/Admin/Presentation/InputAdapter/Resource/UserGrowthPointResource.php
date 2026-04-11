<?php

declare(strict_types=1);

namespace App\Admin\Presentation\InputAdapter\Resource;

use App\Admin\Application\Config\AdminConfig;
use App\Admin\Presentation\InputAdapter\Provider\AdminUsersGrowthProvider;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiResource(
    operations: [
        new GetCollection(
            uriTemplate: '/admin/stats/users-growth',
            paginationEnabled: false,
            provider: AdminUsersGrowthProvider::class,
            normalizationContext: [
                'groups' => [AdminConfig::GROWTH_OUTPUT],
            ],
            security: 'is_granted("ROLE_ADMIN")',
        ),
    ],
)]
final class UserGrowthPointResource
{
    #[Groups([AdminConfig::GROWTH_OUTPUT])]
    public string $month = '';

    #[Groups([AdminConfig::GROWTH_OUTPUT])]
    public int $newUsers = 0;

    #[Groups([AdminConfig::GROWTH_OUTPUT])]
    public int $newPremium = 0;
}
