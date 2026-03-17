<?php

declare(strict_types=1);

namespace App\Profiles\Presentation\InputAdapter\Provider;

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
        /** @var array $routes */
        $routes = $this->service->handle(new GetFavoriteRoutesQuery($uriVariables['username']));

        $resource = new ProfileResource();
        $resource->favoriteRoutes = $routes;
        $resource->favoritesRoutesCount = count($routes);

        return $resource;
    }
}
