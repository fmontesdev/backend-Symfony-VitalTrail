<?php

declare(strict_types=1);

namespace App\Sessions\Application\UseCase\Query\GetSessionsByUser;

use App\Shared\Application\Query\BaseQuery;

final class GetSessionsByUserQuery implements BaseQuery
{
    public function __construct(
        public readonly int $limit = 10,
        public readonly int $offset = 0,
    ) {
    }
}
