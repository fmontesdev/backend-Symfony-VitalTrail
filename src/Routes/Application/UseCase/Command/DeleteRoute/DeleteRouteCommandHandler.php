<?php

declare(strict_types=1);

namespace App\Routes\Application\UseCase\Command\DeleteRoute;

use App\Routes\Application\UseCase\Command\DeleteRoute\DeleteRouteCommand;
use App\Routes\Domain\OutputPort\RouteRepository;
use App\Routes\Application\Service\RouteService;
use App\Routes\Application\Exception\RouteNotFoundException;
use App\Security\Domain\Exception\NotAuthorizedResourceException;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class DeleteRouteCommandHandler
{
    public function __construct(
        private readonly RouteRepository $routeRepository,
        private readonly RouteService $routeService
    ) {
    }

    /**
     * Eliminación de una ruta
     *
     * @param DeleteRouteCommand $command
     */
    public function __invoke(DeleteRouteCommand $command): void
    {
        // Verifica si la ruta existe y si el usuario tiene permisos para acceder a ella
        $route = $this->routeService->findRouteSafe($command->slug);
        if (!$route) {
            throw new RouteNotFoundException($command->slug);
        }
        if (!$this->routeService->isAuthorized($route)) {
            throw new NotAuthorizedResourceException();
        }
        // Elimina la ruta
        $this->routeRepository->remove($route);
    }
}
