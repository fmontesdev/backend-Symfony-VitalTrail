<?php

declare(strict_types=1);

namespace App\Admin\Application\UseCase\Command\DeleteAdminUser;

use App\Shared\Application\Command\BaseCommand;

final readonly class DeleteAdminUserCommand implements BaseCommand
{
    public function __construct(
        public string $userId,
    ) {
    }
}
