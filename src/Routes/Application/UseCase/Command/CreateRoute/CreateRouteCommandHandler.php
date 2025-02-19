<?php

declare(strict_types=1);

namespace App\Routes\Application\UseCase\Command\CreateRoute;

use App\Routes\Application\UseCase\Command\CreateRoute\CreateRouteCommand;
use App\Routes\Application\Dto\RouteDto;
use App\Routes\Application\Service\RouteService;
use App\Routes\Application\Service\ImageRouteService;
use App\Routes\Domain\OutputPort\CategoryRouteRepository;
use App\Security\Domain\Exception\UserIsNotAuthenticatedException;
use App\Routes\Application\Exception\CategoryRouteNotFoundException;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class CreateRouteCommandHandler
{
    public function __construct(
        private readonly RouteService $routeService,
        private readonly ImageRouteService $imageService,
        private readonly CategoryRouteRepository $categoryRouteRepository
    ) {
    }

    /**
     * Creación de una ruta
     *
     * @param CreateRouteCommand $command
     * @return RouteDto|null
     */
    public function __invoke(CreateRouteCommand $command): RouteDto
    {
        // Recupera el usuario actual
        $currentUser = $this->routeService->getContextUser();
        if ($currentUser === null) {
            throw new UserIsNotAuthenticatedException();
        }

        // Recupera la categoría de la ruta
        $categoryRoute = $this->categoryRouteRepository->findByTitle($command->data->categoryTitle);
        if ($categoryRoute === null) {
            throw new CategoryRouteNotFoundException($command->data->categoryTitle);
        }
        $command->data->category = $categoryRoute;

        // Guarda la ruta
        $route = $this->routeService->save($command->data, null, $currentUser);
        
        // Guarda las imágenes de la ruta
        $images = $this->imageService->createRouteImages($command->data->images, $route);
        foreach ($images as $image) {
            $route->addImage($image);
        }
    
        return $this->routeService->toDto($route);
    }
}