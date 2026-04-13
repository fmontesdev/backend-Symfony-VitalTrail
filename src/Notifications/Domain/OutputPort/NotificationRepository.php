<?php

declare(strict_types=1);

namespace App\Notifications\Domain\OutputPort;

use App\Notifications\Domain\Entity\Notification;

interface NotificationRepository
{
    public function save(Notification $notification): void;

    public function findById(int $id): ?Notification;

    public function delete(Notification $notification): void;
}
