<?php

declare(strict_types=1);

namespace App\Routes\Presentation\InputAdapter\Provider;

use App\Routes\Presentation\InputAdapter\Resource\CategoryRouteResource;
use App\Routes\Application\UseCase\Query\GetAllCategoryRoutes\GetAllCategoryRoutesQuery;
use App\Shared\Application\InputPort\ApplicationService;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;

/**
 * @implements ProviderInterface<CategoryRouteResource>
 */
class CategoryRoutesProvider implements ProviderInterface
{
    public function __construct(
        private readonly ApplicationService $service,
    ) {
    }

    /**
     * @param Operation $operation
     * @param string[] $uriVariables
     * @param string[][] $context
     * @return CategoryRouteResource
     */
    public function provide(Operation $operation, array $uriVariables = [], array $context = []): CategoryRouteResource
    {
        $query = new GetAllCategoryRoutesQuery();
        $result = new CategoryRouteResource();
        $result->categories = $this->service->handle($query);

        return $result;
    }
}
