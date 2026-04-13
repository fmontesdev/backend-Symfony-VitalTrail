<?php

declare(strict_types=1);

namespace App\Notifications\Application\UseCase\Command\CreateNotification;

use App\Shared\Application\Command\BaseCommand;

final class CreateNotificationCommand implements BaseCommand
{
    public function __construct(
        public readonly string $title,
        public readonly string $description,
        public readonly string $type,
        public readonly ?string $targetUserId,
        public readonly ?string $targetRole,
    ) {
    }
}
