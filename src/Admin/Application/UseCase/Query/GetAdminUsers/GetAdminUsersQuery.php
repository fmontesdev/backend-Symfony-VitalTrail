<?php

declare(strict_types=1);

namespace App\Admin\Application\UseCase\Query\GetAdminUsers;

use App\Shared\Application\Query\BaseQuery;

final readonly class GetAdminUsersQuery implements BaseQuery
{
    public function __construct(
        public int $page,
        public int $limit,
        public ?string $search,
        public ?string $role,
        public ?bool $isPremium,
        public ?bool $isActive,
    ) {
    }
}
