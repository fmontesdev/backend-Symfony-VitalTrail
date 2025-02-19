<?php

declare(strict_types=1);

namespace App\Profiles\Application\UseCase\Query\GetProfile;

use App\Shared\Application\Query\BaseQuery;

final class GetProfileQuery implements BaseQuery
{
    public function __construct(
        public readonly string $username,
    ) {}
}

