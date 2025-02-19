<?php

declare(strict_types=1);

namespace App\Routes\Application\UseCase\Command\Favorite;

use App\Routes\Domain\Entity\Route;
use App\Auth\Domain\Entity\User;
use App\Routes\Application\UseCase\Command\Favorite\FavoriteCommand;
use App\Routes\Application\Dto\RouteDto;
use App\Routes\Application\Service\RouteService;
use App\Routes\Domain\OutputPort\FavoriteRepository;
use App\Security\Domain\Exception\UserIsNotAuthenticatedException;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class FavoriteCommandHandler
{
    public function __construct(
        private readonly RouteService $routeService,
        private readonly FavoriteRepository $favoriteRepository
    ) {
    }

    /**
     * Marcar favorito/no favorito una ruta
     *
     * @param FavoriteCommand $command
     * @return RouteDto
     */
    public function __invoke(FavoriteCommand $command): RouteDto
    {
        // Recupera el usuario actual
        $currentUser = $this->routeService->getContextUser();
        if ($currentUser === null) {
            throw new UserIsNotAuthenticatedException();
        }

        // Recupera la ruta
        $route = $this->routeService->findRouteSafe($command->slug);

        // Selecciona la acción a realizar según el método HTTP	
        $command->httpMethod !== 'DELETE'
            ? $this->favoriteRoute($route, $currentUser)
            : $this->unfavoriteRoute($route, $currentUser);
    
        return $this->routeService->toDto($route);
    }

    private function favoriteRoute(Route $route, User $user): void
    {
        $this->favoriteRepository->add($route, $user);
    }

    private function unfavoriteRoute(Route $route, User $user): void
    {
        $this->favoriteRepository->remove($route, $user);
    }
}