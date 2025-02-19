<?php

declare(strict_types=1);

namespace App\Routes\Application\UseCase\Command\DeleteRating;

use App\Routes\Application\UseCase\Command\DeleteRating\DeleteRatingCommand;
use App\Routes\Domain\OutputPort\RatingRepository;
use App\Routes\Domain\OutputPort\RouteRepository;
use App\Routes\Application\Service\RatingService;
use App\Routes\Application\Exception\RouteNotFoundException;
use App\Routes\Application\Exception\RatingNotFoundException;
use App\Security\Domain\Exception\NotAuthorizedResourceException;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class DeleteRatingCommandHandler
{
    public function __construct(
        private readonly RatingRepository $ratingRepository,
        private readonly RouteRepository $routeRepository,
        private readonly RatingService $ratingService
    ) {
    }

    /**
     * Eliminación de una valoración de una ruta
     *
     * @param DeleteRatingCommand $command
     */
    public function __invoke(DeleteRatingCommand $command): void
    {
        // Verifica si la valoración y la ruta existen y si el usuario tiene permisos para acceder a ella
        $rating = $this->ratingService->findRatingSafe($command->idRating);
        if (!$rating) {
            throw new RatingNotFoundException($command->idRating);
        }
        $route = $this->routeRepository->findById($rating->getRoute()->getIdRoute());
        if (!$route) {
            throw new RouteNotFoundException($command->slugRoute);
        }
        if (!$this->ratingService->isAuthorized($rating)) {
            throw new NotAuthorizedResourceException();
        }
        $this->ratingRepository->remove($rating);
    }
}
