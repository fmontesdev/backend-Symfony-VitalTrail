<?php

declare(strict_types=1);

namespace App\Routes\Application\UseCase\Query\GetAllRoutes;

use App\Routes\Application\Exception\InvalidSortParameterException;
use App\Routes\Application\UseCase\Query\GetAllRoutes\GetAllRoutesQuery;
use App\Routes\Domain\OutputPort\RouteRepository;
use App\Routes\Application\Service\RouteService;
use App\Routes\Domain\Entity\Route;
use App\Routes\Application\Dto\RouteDto;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class GetAllRoutesQueryHandler
{
    private const ALLOWED_SORT_FIELDS = ['favoritesCount', 'createdAt', 'title', 'distance'];
    private const ALLOWED_SORT_ORDERS = ['asc', 'desc'];

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
     * @param string|null $author
     * @param string|null $sortBy
     * @param string|null $order
     * @return RouteDto[]
     */
    public function __invoke(GetAllRoutesQuery $query): array
    {
        if ($query->sortBy !== null && !in_array($query->sortBy, self::ALLOWED_SORT_FIELDS, true)) {
            throw new InvalidSortParameterException('sortBy', $query->sortBy);
        }
        if ($query->order !== null && !in_array($query->order, self::ALLOWED_SORT_ORDERS, true)) {
            throw new InvalidSortParameterException('order', $query->order);
        }

        $routes = $this->routeRepository->findAllRoutes(
            $query->limit,
            $query->offset,
            $query->category,
            $query->location,
            $query->title,
            $query->distance,
            $query->difficulty,
            $query->typeRoute,
            $query->author,
            $query->sortBy,
            $query->order
        );
        return array_map(fn (Route $route) => $this->routeService->toDto($route, 'getAllRoute'), $routes);
    }
}
