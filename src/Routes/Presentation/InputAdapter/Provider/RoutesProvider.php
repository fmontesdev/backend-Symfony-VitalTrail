<?php

declare(strict_types=1);

namespace App\Routes\Presentation\InputAdapter\Provider;

use App\Routes\Presentation\InputAdapter\Resource\RouteResource;
use App\Routes\Application\UseCase\Query\CountRoutes\CountRoutesQuery;
use App\Routes\Application\UseCase\Query\GetAllRoutes\GetAllRoutesQuery;
use App\Shared\Application\InputPort\ApplicationService;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;

/**
 * @implements ProviderInterface<RouteResource>
 */
class RoutesProvider implements ProviderInterface
{
    public function __construct(
        private readonly ApplicationService $service,
    ) {
    }

    /**
     * @param Operation $operation
     * @param string[] $uriVariables
     * @param mixed[][] $context
     * @return RouteResource
     */
    public function provide(Operation $operation, array $uriVariables = [], array $context = []): RouteResource
    {
        $result = new RouteResource();
        $category = $context['filters']['category'] ?? null;
        $location = $context['filters']['location'] ?? null;
        $title = $context['filters']['title'] ?? null;
        $distance = isset($context['filters']['distance']) ? (int) $context['filters']['distance'] : null;
        $difficulty = $context['filters']['difficulty'] ?? null;
        $typeRoute = $context['filters']['typeRoute'] ?? null;
        $author = $context['filters']['author'] ?? null;
        $limit = intval($context['filters']['limit'] ?? 10);
        $offset = intval($context['filters']['offset'] ?? 0);

        $queryCount = new CountRoutesQuery(
            $category,
            $location,
            $title,
            $distance,
            $difficulty,
            $typeRoute,
            $author
        );
        $result->routesCount = $this->service->handle($queryCount);

        if ($result->routesCount) {
            $queryRoutes = new GetAllRoutesQuery(
                $limit,
                $offset,
                $category,
                $location,
                $title, 
                $distance,
                $difficulty,
                $typeRoute,
                $author
            );
            $result->routes = $this->service->handle($queryRoutes);
        }

        return $result;
    }
}
