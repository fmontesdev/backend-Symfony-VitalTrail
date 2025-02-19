<?php

declare(strict_types=1);

namespace App\Routes\Application\UseCase\Query\CommentsByUser;

use App\Shared\Application\Query\BaseQuery;

final class CommentsByUserQuery implements BaseQuery
{
    public function __construct(
        public readonly string $username,
    ) {}
}