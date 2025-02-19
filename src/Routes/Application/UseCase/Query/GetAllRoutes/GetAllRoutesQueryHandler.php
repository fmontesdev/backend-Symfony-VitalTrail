<?php

declare(strict_types=1);

namespace App\Routes\Application\UseCase\Query\GetAllRoutes;

use App\Routes\Application\UseCase\Query\GetAllRoutes\GetAllRoutesQuery;
use App\Routes\Domain\OutputPort\RouteRepository;
use App\Routes\Application\Service\RouteService;
use App\Routes\Domain\Entity\Route;
use App\Routes\Application\Dto\RouteDto;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class GetAllRoutesQueryHandler
{
    public function __construct(
        private readonly RouteRepository $routeRepository,
        private readonly RouteService $routeService
    ) {
    }

    /**
     * Selecciona todas las rutas
     * 
     * @param integer $limit
     * @param integer $offset
     * @param string|null $category
     * @param string|null $location
     * @param string|null $title
     * @param int|null $distance
     * @param string|null $difficulty
     * @param string|null $typeRoute
     * @return RouteDto[]
     */
    public function __invoke(GetAllRoutesQuery $query): array
    {
        $routes = $this->routeRepository->findAllRoutes(
            $query->limit,
            $query->offset,
            $query->category,
            $query->location,
            $query->title,
            $query->distance,
            $query->difficulty,
            $query->typeRoute,
            $query->author
        );
        return array_map(fn (Route $route) => $this->routeService->toDto($route, 'getAllRoute'), $routes);
    }
}
