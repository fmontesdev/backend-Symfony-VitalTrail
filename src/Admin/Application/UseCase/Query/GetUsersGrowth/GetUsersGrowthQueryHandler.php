<?php

declare(strict_types=1);

namespace App\Admin\Application\UseCase\Query\GetUsersGrowth;

use App\Admin\Application\Dto\UserGrowthPointDto;
use App\Auth\Domain\OutputPort\UserRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class GetUsersGrowthQueryHandler
{
    public function __construct(
        private UserRepository $userRepository,
    ) {
    }

    /**
     * @return UserGrowthPointDto[]
     */
    public function __invoke(GetUsersGrowthQuery $query): array
    {
        $rows = $this->userRepository->getUsersGrowthByMonth($query->months);

        return array_map(
            static fn(array $row): UserGrowthPointDto => new UserGrowthPointDto(
                month: $row['month'],
                newUsers: (int) $row['newUsers'],
                newPremium: (int) $row['newPremium'],
            ),
            $rows,
        );
    }
}
