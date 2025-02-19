<?php

declare(strict_types=1);

namespace App\Routes\Application\UseCase\Query\CommentsByRoute;

use App\Shared\Application\Query\BaseQuery;

final class CommentsByRouteQuery implements BaseQuery
{
    public function __construct(
        public readonly string $slug,
    ) {}
}