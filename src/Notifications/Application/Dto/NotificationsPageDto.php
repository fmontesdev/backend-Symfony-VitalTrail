<?php

declare(strict_types=1);

namespace App\Notifications\Application\Dto;

final class NotificationsPageDto
{
    /**
     * @param NotificationDto[] $notifications
     */
    public function __construct(
        public array $notifications,
        public int $unreadCount,
    ) {
    }
}
