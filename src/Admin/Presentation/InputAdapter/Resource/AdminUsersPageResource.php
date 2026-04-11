<?php

declare(strict_types=1);

namespace App\Admin\Presentation\InputAdapter\Resource;

use App\Admin\Application\Config\AdminConfig;
use App\Admin\Application\Dto\AdminUserDto;
use App\Admin\Presentation\InputAdapter\Provider\AdminUsersProvider;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiResource(
    operations: [
        new GetCollection(
            uriTemplate: '/admin/users',
            paginationEnabled: false,
            provider: AdminUsersProvider::class,
            normalizationContext: [
                'groups' => [AdminConfig::USERS_OUTPUT],
            ],
            security: 'is_granted("ROLE_ADMIN")',
        ),
    ],
)]
final class AdminUsersPageResource
{
    /** @var array<int, AdminUserDto> */
    #[Groups([AdminConfig::USERS_OUTPUT])]
    public array $users = [];

    #[Groups([AdminConfig::USERS_OUTPUT])]
    public int $total = 0;

    #[Groups([AdminConfig::USERS_OUTPUT])]
    public int $page = 1;

    #[Groups([AdminConfig::USERS_OUTPUT])]
    public int $limit = 20;
}
