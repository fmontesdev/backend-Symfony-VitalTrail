<?php

declare(strict_types=1);

namespace App\Admin\Presentation\InputAdapter\Provider;

use App\Admin\Application\Dto\RouteGrowthPointDto;
use App\Admin\Application\UseCase\Query\GetRoutesGrowth\GetRoutesGrowthQuery;
use App\Admin\Presentation\InputAdapter\Resource\RouteGrowthPointResource;
use App\Admin\Presentation\Mapper\AdminStatsMapper;
use App\Shared\Application\InputPort\ApplicationService;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * @implements ProviderInterface<RouteGrowthPointResource>
 */
final class AdminRoutesGrowthProvider implements ProviderInterface
{
    public function __construct(
        private readonly ApplicationService $service,
        private readonly RequestStack $requestStack,
    ) {
    }

    /**
     * @param Operation $operation
     * @param mixed[] $uriVariables
     * @param string[][] $context
     * @return RouteGrowthPointResource[]
     */
    public function provide(Operation $operation, array $uriVariables = [], array $context = []): array
    {
        $months = (int) ($this->requestStack->getCurrentRequest()?->query->get('months', 12) ?? 12);
        $months = max(1, min(24, $months));

        /** @var RouteGrowthPointDto[] $dtos */
        $dtos = $this->service->handle(new GetRoutesGrowthQuery($months));

        return array_map(
            static fn(RouteGrowthPointDto $dto): RouteGrowthPointResource => AdminStatsMapper::mapRouteGrowthDtoToResource($dto),
            $dtos,
        );
    }
}
