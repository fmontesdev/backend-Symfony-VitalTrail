<?php

declare(strict_types=1);

namespace App\Profiles\Application\UseCase\Command\Follow;

use App\Shared\Application\Command\BaseCommand;

final class FollowCommand implements BaseCommand
{
    public function __construct(
        public readonly string $username,
        public readonly string $httpMethod
    ) {}
}