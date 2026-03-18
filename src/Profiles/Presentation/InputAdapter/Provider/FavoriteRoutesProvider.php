<?php

declare(strict_types=1);

namespace App\Profiles\Presentation\InputAdapter\Provider;

use App\Profiles\Application\UseCase\Query\CountFavoriteRoutes\CountFavoriteRoutesQuery;
use App\Profiles\Application\UseCase\Query\GetFavoriteRoutes\GetFavoriteRoutesQuery;
use App\Profiles\Presentation\InputAdapter\Resource\ProfileResource;
use App\Shared\Application\InputPort\ApplicationService;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;

/**
 * @implements ProviderInterface<ProfileResource>
 */
final class FavoriteRoutesProvider implements ProviderInterface
{
    public function __construct(
        private readonly ApplicationService $service,
    ) {
    }

    /**
     * @param Operation    $operation
     * @param mixed[]      $uriVariables
     * @param mixed[]      $context
     */
    public function provide(Operation $operation, array $uriVariables = [], array $context = []): ProfileResource
    {
        $filters = $context['filters'] ?? [];
        $limit = isset($filters['limit']) ? (int) $filters['limit'] : 10;
        $offset = isset($filters['offset']) ? (int) $filters['offset'] : 0;

        $resource = new ProfileResource();
        $resource->favoritesRoutesCount = (int) $this->service->handle(
            new CountFavoriteRoutesQuery($uriVariables['username'])
        );

        if ($resource->favoritesRoutesCount > 0) {
            /** @var array $routes */
            $routes = $this->service->handle(
                new GetFavoriteRoutesQuery($uriVariables['username'], $limit, $offset)
            );
            $resource->favoriteRoutes = $routes;
        }

        return $resource;
    }
}
