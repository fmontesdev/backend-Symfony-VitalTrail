<?php

declare(strict_types=1);

namespace App\Notifications\Application\UseCase\Command\MarkNotificationRead;

use App\Shared\Application\Command\BaseCommand;

final class MarkNotificationReadCommand implements BaseCommand
{
    public function __construct(
        public readonly int $notificationId,
        public readonly string $userId,
    ) {
    }
}
