<?php

declare(strict_types=1);

namespace App\Admin\Presentation\InputAdapter\Provider;

use App\Admin\Application\Dto\AdminUsersPageDto;
use App\Admin\Application\UseCase\Query\GetAdminUsers\GetAdminUsersQuery;
use App\Admin\Presentation\InputAdapter\Resource\AdminUsersPageResource;
use App\Admin\Presentation\Mapper\AdminUserMapper;
use App\Shared\Application\InputPort\ApplicationService;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * @implements ProviderInterface<AdminUsersPageResource>
 */
final class AdminUsersProvider implements ProviderInterface
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
     * @return AdminUsersPageResource
     */
    public function provide(Operation $operation, array $uriVariables = [], array $context = []): AdminUsersPageResource
    {
        $request = $this->requestStack->getCurrentRequest();

        $page = max(1, (int) $request?->query->get('page', 1));
        $limit = max(1, min(100, (int) $request?->query->get('limit', 20)));
        $search = $request?->query->get('search') ?: null;
        $role = $request?->query->get('role') ?: null;
        $isPremiumRaw = $request?->query->get('isPremium');
        $isPremium = $isPremiumRaw !== null
            ? filter_var($isPremiumRaw, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE)
            : null;

        /** @var AdminUsersPageDto $dto */
        $dto = $this->service->handle(new GetAdminUsersQuery($page, $limit, $search, $role, $isPremium));

        return AdminUserMapper::mapPageDtoToResource($dto);
    }
}
