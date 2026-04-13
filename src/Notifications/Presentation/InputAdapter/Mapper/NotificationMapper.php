<?php

declare(strict_types=1);

namespace App\Notifications\Presentation\InputAdapter\Mapper;

use App\Notifications\Application\Dto\NotificationDto;
use App\Notifications\Domain\Entity\NotificationsUsers;
use App\Notifications\Presentation\InputAdapter\Resource\NotificationListResource;
use App\Notifications\Application\Dto\NotificationsPageDto;

final class NotificationMapper
{
    public static function mapToDto(NotificationsUsers $nu): NotificationDto
    {
        $notification = $nu->getNotification();

        $dto = new NotificationDto();
        $dto->id = (int) $notification->getIdNotification();
        $dto->title = $notification->getTitle();
        $dto->description = $notification->getDescription();
        $dto->type = $notification->getType();
        $dto->isRead = $nu->isRead();
        $dto->readAt = $nu->getReadAt();
        $dto->createdAt = $notification->getCreatedAt() ?? new \DateTimeImmutable();

        return $dto;
    }

    public static function mapPageToResource(NotificationsPageDto $dto): NotificationListResource
    {
        $resource = new NotificationListResource();
        $resource->notifications = $dto->notifications;
        $resource->unreadCount = $dto->unreadCount;

        return $resource;
    }
}
