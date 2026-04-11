<?php

declare(strict_types=1);

namespace App\Admin\Presentation\InputAdapter\Provider;

use App\Admin\Application\Dto\UserGrowthPointDto;
use App\Admin\Application\UseCase\Query\GetUsersGrowth\GetUsersGrowthQuery;
use App\Admin\Presentation\InputAdapter\Resource\UserGrowthPointResource;
use App\Admin\Presentation\Mapper\AdminStatsMapper;
use App\Shared\Application\InputPort\ApplicationService;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * @implements ProviderInterface<UserGrowthPointResource>
 */
final class AdminUsersGrowthProvider implements ProviderInterface
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
     * @return UserGrowthPointResource[]
     */
    public function provide(Operation $operation, array $uriVariables = [], array $context = []): array
    {
        $months = (int) ($this->requestStack->getCurrentRequest()?->query->get('months', 12) ?? 12);
        $months = max(1, min(24, $months));

        /** @var UserGrowthPointDto[] $dtos */
        $dtos = $this->service->handle(new GetUsersGrowthQuery($months));

        return array_map(
            static fn(UserGrowthPointDto $dto): UserGrowthPointResource => AdminStatsMapper::mapUserGrowthDtoToResource($dto),
            $dtos,
        );
    }
}
