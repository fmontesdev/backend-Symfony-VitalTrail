<?php

declare(strict_types=1);

namespace App\Sessions\Application\UseCase\Query\GetCheckin;

use App\Shared\Application\Query\BaseQuery;

final class GetCheckinQuery implements BaseQuery
{
    public function __construct(
        public readonly int $idSession,
    ) {
    }
}
