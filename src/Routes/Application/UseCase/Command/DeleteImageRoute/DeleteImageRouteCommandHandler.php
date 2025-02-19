<?php

declare(strict_types=1);

namespace App\Routes\Application\UseCase\Command\DeleteImageRoute;

use App\Routes\Application\UseCase\Command\DeleteImageRoute\DeleteImageRouteCommand;
use App\Routes\Domain\OutputPort\ImageRouteRepository;
use App\Routes\Domain\OutputPort\RouteRepository;
use App\Routes\Application\Service\ImageRouteService;
use App\Routes\Application\Service\RouteService;
use App\Routes\Application\Exception\RouteNotFoundException;
use App\Routes\Application\Exception\ImageRouteNotFoundException;
use App\Security\Domain\Exception\NotAuthorizedResourceException;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class DeleteImageRouteCommandHandler
{
    public function __construct(
        private readonly ImageRouteRepository $imageRouteRepository,
        private readonly RouteRepository $routeRepository,
        private readonly ImageRouteService $imageService,
        private readonly RouteService $routeService
    ) {
    }

    /**
     * Eliminación de una imagen de una ruta
     *
     * @param DeleteImageRouteCommand $command
     */
    public function __invoke(DeleteImageRouteCommand $command): void
    {
        // Verifica si la imagen y la ruta existen y si el usuario tiene permisos para acceder a ella
        $imageRoute = $this->imageService->findImageRouteSafe($command->idImg);
        if (!$imageRoute) {
            throw new ImageRouteNotFoundException($command->idImg);
        }
        $route = $this->routeRepository->findById($imageRoute->getRoute()->getIdRoute());
        if (!$route) {
            throw new RouteNotFoundException(null);
        }
        if (!$this->routeService->isAuthorized($route)) {
            throw new NotAuthorizedResourceException();
        }
        $this->imageRouteRepository->remove($imageRoute);
    }
}
