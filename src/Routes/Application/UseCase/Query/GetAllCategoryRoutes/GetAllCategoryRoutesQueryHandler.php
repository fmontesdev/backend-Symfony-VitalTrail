<?php

declare(strict_types=1);

namespace App\Routes\Application\UseCase\Query\GetAllCategoryRoutes;

use App\Routes\Application\UseCase\Query\GetAllCategoryRoutes\GetAllCategoryRoutesQuery;
use App\Routes\Domain\OutputPort\CategoryRouteRepository;
use App\Routes\Application\Service\CategoryRouteService;
use App\Routes\Domain\Entity\CategoryRoute;
use App\Routes\Application\Dto\CategoryRouteDto;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class GetAllCategoryRoutesQueryHandler
{
    public function __construct(
        private readonly CategoryRouteRepository $categoryRouteRepository,
        private readonly CategoryRouteService $categoryRouteService
    ) {
    }

    /**
     * Selecciona todas las categorias de rutas
     *
     * @param GetAllCategoryRoutesQuery $query
     * @return CategoryRouteDto[]
     */
    public function __invoke(GetAllCategoryRoutesQuery $query): array
    {
        $categories = $this->categoryRouteRepository->findAllCategoryRoutes();
        return array_map(fn (CategoryRoute $category) => $this->categoryRouteService->toDto($category), $categories);
    }
}
