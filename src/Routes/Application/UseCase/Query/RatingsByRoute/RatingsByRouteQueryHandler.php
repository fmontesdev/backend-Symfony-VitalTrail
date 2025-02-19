<?php

declare(strict_types=1);

namespace App\Routes\Application\UseCase\Query\RatingsByRoute;

use App\Routes\Application\UseCase\Query\RatingsByRoute\RatingsByRouteQuery;
use App\Routes\Domain\Entity\Rating;
use App\Routes\Application\Dto\RatingDto;
use App\Routes\Domain\OutputPort\RatingRepository;
use App\Routes\Domain\OutputPort\CommentRepository;
use App\Routes\Domain\OutputPort\RouteRepository;
use App\Routes\Application\Service\RouteService;
use App\Routes\Application\Service\RatingService;
use App\Routes\Application\Exception\RouteNotFoundException;
use App\Routes\Application\Exception\CommentNotFoundException;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class RatingsByRouteQueryHandler
{
    public function __construct(
        private readonly RatingRepository $ratingRepository,
        private readonly CommentRepository $commentRepository,
        private readonly RouteRepository $routeRepository,
        private readonly RatingService $ratingService,
        private readonly RouteService $routeService
    ) {
    }

    /**
     * Selecciona todas las valoraciones de una ruta
     *
     * @param RatingsByRouteQuery $query
     * @return RatingDto[]|null
     */
    public function __invoke(RatingsByRouteQuery $query): ?array
    {
        // Verifica si la ruta existe
        $route = $this->routeRepository->findBySlug($query->slugRoute);
        if (!$route) {
            throw new RouteNotFoundException($query->slugRoute);
        }
        
        // Obtiene los ratings de la ruta
        $ratings = $this->ratingRepository->findRatingsByRoute($route->getIdRoute());
        if (!$ratings) {
            return null;
        }
        return array_map(fn (Rating $rating) => $this->ratingService->toDto($rating), $ratings);
    }
}
