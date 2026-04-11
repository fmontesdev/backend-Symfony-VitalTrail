<?php

declare(strict_types=1);

namespace App\Admin\Application\UseCase\Query\GetAdminUsers;

use App\Admin\Application\Dto\AdminUsersPageDto;
use App\Admin\Presentation\Mapper\AdminUserMapper;
use App\Auth\Domain\OutputPort\UserRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class GetAdminUsersQueryHandler
{
    public function __construct(
        private UserRepository $userRepository,
    ) {
    }

    public function __invoke(GetAdminUsersQuery $query): AdminUsersPageDto
    {
        $users = $this->userRepository->findPaginatedForAdmin(
            $query->page,
            $query->limit,
            $query->search,
            $query->role,
            $query->isPremium,
        );

        $total = $this->userRepository->countForAdmin(
            $query->search,
            $query->role,
            $query->isPremium,
        );

        $userDtos = array_map(
            static fn($user) => AdminUserMapper::mapEntityToDto($user),
            $users,
        );

        return new AdminUsersPageDto(
            users: $userDtos,
            total: $total,
            page: $query->page,
            limit: $query->limit,
        );
    }
}
