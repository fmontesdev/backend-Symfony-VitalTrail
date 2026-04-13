<?php

declare(strict_types=1);

namespace App\Notifications\Application\Dto;

final class NotificationDto
{
    public int $id;
    public string $title;
    public string $description;
    public string $type;
    public bool $isRead;
    public ?\DateTimeInterface $readAt;
    public \DateTimeImmutable $createdAt;
}
