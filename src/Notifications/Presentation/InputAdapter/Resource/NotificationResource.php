<?php

declare(strict_types=1);

namespace App\Notifications\Presentation\InputAdapter\Resource;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\NotExposed;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Notifications\Presentation\InputAdapter\Processor\CreateNotificationProcessor;
use App\Notifications\Presentation\InputAdapter\Processor\DeleteNotificationProcessor;
use App\Notifications\Presentation\InputAdapter\Processor\MarkAllReadProcessor;
use App\Notifications\Presentation\InputAdapter\Processor\MarkReadProcessor;

#[ApiResource(
    operations: [
        new Patch(
            uriTemplate: '/notifications/{id}/read',
            read: false,
            input: false,
            processor: MarkReadProcessor::class,
            security: 'is_granted("ROLE_CLIENT") or is_granted("ROLE_ADMIN")',
        ),
        new Patch(
            uriTemplate: '/notifications/read-all',
            read: false,
            input: false,
            processor: MarkAllReadProcessor::class,
            security: 'is_granted("ROLE_CLIENT") or is_granted("ROLE_ADMIN")',
        ),
        new Post(
            uriTemplate: '/notifications',
            processor: CreateNotificationProcessor::class,
            security: 'is_granted("ROLE_ADMIN")',
        ),
        new Delete(
            uriTemplate: '/notifications/{id}',
            read: false,
            processor: DeleteNotificationProcessor::class,
            security: 'is_granted("ROLE_ADMIN")',
        ),
        new NotExposed(uriTemplate: '/notifications/{id}'),
    ]
)]
class NotificationResource
{
    #[ApiProperty(identifier: true)]
    public ?int $id = null;

    public ?string $title = null;

    public ?string $description = null;

    /** 'system'|'social'|'subscription'|'admin' */
    public ?string $type = null;

    /** null = broadcast to all users */
    public ?string $targetUserId = null;

    /** 'ROLE_CLIENT'|'ROLE_ADMIN' — null = todos los roles */
    public ?string $targetRole = null;
}
