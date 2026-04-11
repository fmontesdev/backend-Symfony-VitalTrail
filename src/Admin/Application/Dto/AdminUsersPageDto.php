<?php

declare(strict_types=1);

namespace App\Admin\Application\Dto;

final class AdminUsersPageDto
{
    /**
     * @param AdminUserDto[] $users
     */
    public function __construct(
        public readonly array $users,
        public readonly int $total,
        public readonly int $page,
        public readonly int $limit,
    ) {
    }
}
