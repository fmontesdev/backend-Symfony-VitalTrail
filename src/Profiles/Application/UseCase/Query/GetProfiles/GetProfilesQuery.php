<?php

declare(strict_types=1);

namespace App\Profiles\Application\UseCase\Query\GetProfiles;

use App\Shared\Application\Query\BaseQuery;

final class GetProfilesQuery implements BaseQuery
{
    public function __construct(
        public readonly string $username,
        public readonly string $follows,
    ) {}
}

