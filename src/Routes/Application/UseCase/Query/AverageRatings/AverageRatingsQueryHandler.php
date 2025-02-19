<?php

declare(strict_types=1);

namespace App\Routes\Application\UseCase\Query\AverageRatings;

use App\Routes\Application\UseCase\Query\AverageRatings\AverageRatingsQuery;
use App\Routes\Domain\OutputPort\RatingRepository;
use App\Routes\Domain\OutputPort\RouteRepository;
use App\Routes\Application\Exception\RouteNotFoundException;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class AverageRatingsQueryHandler
{
    public function __construct(
        private readonly RatingRepository $ratingRepository,
        private readonly RouteRepository $routeRepository
    ) {
    }

    /**
     * Media del total de ratings en una ruta
     *
     * @param AverageRatingsQuery $query
     * @return int
     */
    public function __invoke(AverageRatingsQuery $query): float
    {
        // Verifica si la ruta existe
        $route = $this->routeRepository->findBySlug($query->slugRoute);
        if (!$route) {
            throw new RouteNotFoundException($query->slugRoute);
        }

        // Obtiene la media del total de ratings de la ruta
        return $this->ratingRepository->averageRatings( $route->getIdRoute());
    }
}
