<?php

declare(strict_types=1);

namespace App\Routes\Application\UseCase\Command\Favorite;

use App\Shared\Application\Command\BaseCommand;

final class FavoriteCommand implements BaseCommand
{
    public function __construct(
        public readonly string $slug,
        public readonly string $httpMethod
    ) {}
}