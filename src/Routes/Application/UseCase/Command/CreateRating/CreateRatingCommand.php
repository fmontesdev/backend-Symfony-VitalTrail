<?php

declare(strict_types=1);

namespace App\Routes\Application\UseCase\Command\CreateRating;

use App\Shared\Application\Command\BaseCommand;
use App\Routes\Application\Dto\RatingDto;

final class CreateRatingCommand implements BaseCommand
{
    public function __construct(
        public readonly RatingDto $data,
        public readonly string $slugRoute,
    ) {}
}