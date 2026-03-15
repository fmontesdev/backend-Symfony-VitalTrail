<?php

declare(strict_types=1);

namespace App\Stats\Presentation\InputAdapter\Provider;

use App\Stats\Application\Dto\StatsDto;
use App\Stats\Application\UseCase\Query\GetPlatformStats\GetPlatformStatsQuery;
use App\Stats\Presentation\InputAdapter\Resource\StatsResource;
use App\Stats\Presentation\Mapper\StatsMapper;
use App\Shared\Application\InputPort\ApplicationService;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;

/**
 * @implements ProviderInterface<StatsResource>
 */
final class StatsProvider implements ProviderInterface
{
    public function __construct(
        private readonly ApplicationService $service,
    ) {
    }

    /**
     * @param Operation $operation
     * @param mixed[] $uriVariables
     * @param string[][] $context
     * @return StatsResource
     */
    public function provide(Operation $operation, array $uriVariables = [], array $context = []): StatsResource
    {
        /** @var StatsDto $dto */
        $dto = $this->service->handle(new GetPlatformStatsQuery());

        return StatsMapper::mapDtoToResource($dto);
    }
}
