<?php

declare(strict_types=1);

namespace App\Notifications\Application\UseCase\Command\MarkAllNotificationsRead;

use App\Shared\Application\Command\BaseCommand;

final class MarkAllNotificationsReadCommand implements BaseCommand
{
    public function __construct(
        public readonly string $userId,
    ) {
    }
}
