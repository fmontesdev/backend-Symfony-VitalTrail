<?php

declare(strict_types=1);

namespace App\Notifications\Application\UseCase\Command\DeleteNotification;

use App\Shared\Application\Command\BaseCommand;

final class DeleteNotificationCommand implements BaseCommand
{
    public function __construct(
        public readonly int $notificationId,
    ) {
    }
}
