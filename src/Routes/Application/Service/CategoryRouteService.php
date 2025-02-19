<?php

declare(strict_types=1);

namespace App\Routes\Application\Service;

use App\Routes\Domain\Entity\CategoryRoute;
use App\Routes\Application\Dto\CategoryRouteDto;
use App\Routes\Presentation\Mapper\CategoryRouteMapper;
// use App\Routes\Domain\OutputPort\CategoryRouteRepository;

class CategoryRouteService
{
    public function __construct(
        // private readonly CategoryRouteRepository $categoryRouteRepository,
        private readonly CategoryRouteMapper $categoryRouteMapper
    ) {
    }

    public function toDto(CategoryRoute $entity): CategoryRouteDto
    {
        return $this->categoryRouteMapper->mapEntityToDto($entity);
    }
}