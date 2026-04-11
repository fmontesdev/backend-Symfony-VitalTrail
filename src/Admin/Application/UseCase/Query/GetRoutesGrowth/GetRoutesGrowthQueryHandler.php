<?php

declare(strict_types=1);

namespace App\Admin\Application\UseCase\Query\GetRoutesGrowth;

use App\Admin\Application\Dto\RouteGrowthPointDto;
use App\Routes\Domain\OutputPort\RouteRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class GetRoutesGrowthQueryHandler
{
    public function __construct(
        private RouteRepository $routeRepository,
    ) {
    }

    /**
     * @return RouteGrowthPointDto[]
     */
    public function __invoke(GetRoutesGrowthQuery $query): array
    {
        $rows = $this->routeRepository->getRoutesGrowthByMonth($query->months);

        return array_map(
            static fn(array $row): RouteGrowthPointDto => new RouteGrowthPointDto(
                month: $row['month'],
                newRoutes: (int) $row['newRoutes'],
            ),
            $rows,
        );
    }
}
