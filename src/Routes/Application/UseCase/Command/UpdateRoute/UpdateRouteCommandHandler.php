<?php

declare(strict_types=1);

namespace App\Routes\Application\UseCase\Command\UpdateRoute;

use App\Routes\Application\UseCase\Command\UpdateRoute\UpdateRouteCommand;
use App\Routes\Application\Dto\RouteDto;
use App\Routes\Application\Service\RouteService;
use App\Routes\Domain\OutputPort\CategoryRouteRepository;
use App\Routes\Application\Exception\RouteNotFoundException;
use App\Security\Domain\Exception\NotAuthorizedResourceException;
use App\Routes\Application\Exception\CategoryRouteNotFoundException;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class UpdateRouteCommandHandler
{
    public function __construct(
        private readonly RouteService $routeService,
        private readonly CategoryRouteRepository $categoryRouteRepository
    ) {
    }

    /**
     * Actualización de una ruta
     *
     * @param UpdateRouteCommand $command
     * @return RouteDto
     */
    public function __invoke(UpdateRouteCommand $command): RouteDto
    {
        // Verifica si la ruta existe y si el usuario tiene permisos para acceder a ella
        $route = $this->routeService->findRouteSafe($command->slug);
        if (!$route) {
            throw new RouteNotFoundException($command->slug);
        }
        if (!$this->routeService->isAuthorized($route)) {
            throw new NotAuthorizedResourceException();
        }

        // Recupera la categoría de la ruta
        $categoryRoute = $this->categoryRouteRepository->findByTitle($command->data->categoryTitle);
        if ($categoryRoute === null) {
            throw new CategoryRouteNotFoundException($command->data->categoryTitle);
        }
        $command->data->category = $categoryRoute;

        // Actualiza la ruta
        $updatedRoute = $this->routeService->save($command->data, $route);
    
        return $this->routeService->toDto($updatedRoute);
    }
}
