<?php

declare(strict_types=1);

namespace App\Routes\Application\UseCase\Command\AddImageRoute;

use App\Routes\Application\UseCase\Command\AddImageRoute\AddImageToRouteCommand;
use App\Routes\Domain\Entity\ImageRoute;
use App\Routes\Application\Dto\ImageRouteDto;
use App\Routes\Domain\OutputPort\ImageRouteRepository;
use App\Routes\Domain\OutputPort\RouteRepository;
use App\Routes\Application\Service\ImageRouteService;
use App\Routes\Application\Service\RouteService;
use App\Security\Domain\Exception\NotAuthorizedResourceException;
use App\Routes\Application\Exception\RouteNotFoundException;
use App\Routes\Application\Exception\RouteImagesNotFoundException;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class AddImageToRouteCommandHandler
{
    public function __construct(
        private readonly ImageRouteRepository $imageRepository,
        private readonly RouteRepository $routeRepository,
        private readonly ImageRouteService $imageService,
        private readonly RouteService $routeService
        
    ) {
    }

    /**
     * Añadir imagen a una ruta
     *
     * @param AddImageToRouteCommand $command
     * @return ImageRouteDto[]
     */
    public function __invoke(AddImageToRouteCommand $command): array
    {
        // Verifica si la ruta existe y si el usuario tiene permisos para acceder a ella
        $route = $this->routeRepository->findById($command->idRoute);
        if (!$route) {
            throw new RouteNotFoundException(null);
        }
        if (!$this->routeService->isAuthorized($route)) {
            throw new NotAuthorizedResourceException();
        }

        // Guarda la imagen en la base de datos
        $image = $this->imageService->save($command->data->imgRoute, $route, null);

        // Obtiene las imagenes de la ruta
        $images = $this->imageRepository->findImagesByRoute($command->idRoute);
        if (empty($images)) {
            throw new RouteImagesNotFoundException($command->idRoute );
        }
        return array_map(fn (ImageRoute $image) => $this->imageService->toDto($image), $images);
    }
}
