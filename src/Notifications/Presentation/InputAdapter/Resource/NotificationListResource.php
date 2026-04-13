<?php

declare(strict_types=1);

namespace App\Notifications\Presentation\InputAdapter\Resource;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use App\Notifications\Application\Dto\NotificationDto;
use App\Notifications\Presentation\InputAdapter\Provider\MyNotificationsProvider;

#[ApiResource(
    operations: [
        new GetCollection(
            uriTemplate: '/notifications/me',
            provider: MyNotificationsProvider::class,
            security: 'is_granted("ROLE_CLIENT") or is_granted("ROLE_ADMIN")',
        ),
    ]
)]
class NotificationListResource
{
    /** @var NotificationDto[] */
    public array $notifications = [];

    public int $unreadCount = 0;
}
