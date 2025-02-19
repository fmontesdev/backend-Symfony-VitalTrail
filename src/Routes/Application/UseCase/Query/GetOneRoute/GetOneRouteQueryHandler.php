<?php

declare(strict_types=1);

namespace App\Routes\Application\UseCase\Query\GetOneRoute;

use App\Routes\Application\UseCase\Query\GetOneRoute\GetOneRouteQuery;
use App\Routes\Application\Service\RouteService;
use App\Routes\Application\Dto\RouteDto;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class GetOneRouteQueryHandler
{
    public function __construct(
        private readonly RouteService $routeService
    ) {
    }

    /**
     * Selecciona una ruta
     *
     * @param GetOneRouteQuery $query
     * @return RouteDto|null
     */
    public function __invoke(GetOneRouteQuery $query): ?RouteDto
    {
        $route = $this->routeService->findRouteSafe($query->slug);
        if ($route !== null) {
            $result = $this->routeService->toDto($route, 'getOneRoute');
        }
        return $result;
    }
}
