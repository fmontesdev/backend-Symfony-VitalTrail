<?php

declare(strict_types=1);

namespace App\Notifications\Domain\OutputPort;

use App\Notifications\Domain\Entity\NotificationsUsers;

interface NotificationsUsersRepository
{
    public function save(NotificationsUsers $nu): void;

    /**
     * @return NotificationsUsers[]
     */
    public function findByUser(string $userId): array;

    public function countUnreadByUser(string $userId): int;

    public function findByNotificationAndUser(int $notificationId, string $userId): ?NotificationsUsers;

    /**
     * @return NotificationsUsers[]
     */
    public function findAllUnreadByUser(string $userId): array;
}
