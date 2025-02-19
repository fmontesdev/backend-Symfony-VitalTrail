<?php

declare(strict_types=1);

namespace App\Routes\Presentation\InputAdapter\Provider;

use App\Routes\Presentation\InputAdapter\Resource\RouteResource;
use App\Routes\Application\UseCase\Query\GetOneRoute\GetOneRouteQuery;
use App\Shared\Application\InputPort\ApplicationService;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;

/**
 * @implements ProviderInterface<RouteResource>
 */
class RouteProvider implements ProviderInterface
{
    public function __construct(
        private readonly ApplicationService $service,
    ) {
    }

    /**
     * @param Operation $operation
     * @param string[] $uriVariables
     * @param string[][] $context
     * @return RouteResource|null
     */
    public function provide(Operation $operation, array $uriVariables = [], array $context = []): ?RouteResource
    {
        $query = new GetOneRouteQuery($uriVariables['slug']);
        $route = $this->service->handle($query);
        if ($route) {
            $result = new RouteResource();
            $result->route = $route;
            return $result;
        }
        return null;
    }
}
