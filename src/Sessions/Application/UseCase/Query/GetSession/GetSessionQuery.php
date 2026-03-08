<?php

declare(strict_types=1);

namespace App\Sessions\Application\UseCase\Query\GetSession;

use App\Shared\Application\Query\BaseQuery;

final class GetSessionQuery implements BaseQuery
{
    public function __construct(
        public readonly int $idSession,
    ) {
    }
}
