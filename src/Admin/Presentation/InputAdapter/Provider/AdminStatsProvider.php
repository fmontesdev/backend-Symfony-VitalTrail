<?php

declare(strict_types=1);

namespace App\Admin\Presentation\InputAdapter\Provider;

use App\Admin\Application\Dto\AdminStatsDto;
use App\Admin\Application\UseCase\Query\GetAdminStats\GetAdminStatsQuery;
use App\Admin\Presentation\InputAdapter\Resource\AdminStatsResource;
use App\Admin\Presentation\Mapper\AdminStatsMapper;
use App\Shared\Application\InputPort\ApplicationService;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;

/**
 * @implements ProviderInterface<AdminStatsResource>
 */
final class AdminStatsProvider implements ProviderInterface
{
    public function __construct(
        private readonly ApplicationService $service,
    ) {
    }

    /**
     * @param Operation $operation
     * @param mixed[] $uriVariables
     * @param string[][] $context
     * @return AdminStatsResource
     */
    public function provide(Operation $operation, array $uriVariables = [], array $context = []): AdminStatsResource
    {
        /** @var AdminStatsDto $dto */
        $dto = $this->service->handle(new GetAdminStatsQuery());

        return AdminStatsMapper::mapDtoToResource($dto);
    }
}
