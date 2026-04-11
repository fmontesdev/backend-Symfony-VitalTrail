<?php

declare(strict_types=1);

namespace App\Admin\Presentation\InputAdapter\Resource;

use App\Admin\Presentation\InputAdapter\Processor\AdminUserDeleteProcessor;
use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\NotExposed;

#[ApiResource(
    operations: [
        new Delete(
            uriTemplate: '/admin/users/{idUser}',
            read: false,
            processor: AdminUserDeleteProcessor::class,
            security: 'is_granted("ROLE_ADMIN")',
        ),
        new NotExposed(
            uriTemplate: '/admin/users/{idUser}',
        ),
    ],
)]
final class AdminUserResource
{
    #[ApiProperty(identifier: true)]
    public ?string $idUser = null;
}
