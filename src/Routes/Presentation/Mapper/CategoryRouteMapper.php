<?php

declare(strict_types=1);

namespace App\Routes\Presentation\Mapper;

use App\Routes\Domain\Entity\CategoryRoute;
use App\Routes\Application\Dto\CategoryRouteDto;
use App\Routes\Presentation\Mapper\RouteMapper;

class CategoryRouteMapper
{
    public function __construct(
        private RouteMapper $routeMapper
    ) {
    }
    public function mapDtoToEntity(CategoryRouteDto $dto, ?CategoryRoute $entity = null): CategoryRoute
    {
        $result = $entity ?: new CategoryRoute();
        if ($dto->title !== null) {
            $result->setTitle($dto->title);
        }
        if ($dto->description !== null) {
            $result->setDescription($dto->description);
        }
        if ($dto->imgCategory !== null) {
            $result->setImgCategory($dto->imgCategory);
        }
        return $result;
    }

    public function mapEntityToDto(CategoryRoute $entity): CategoryRouteDto
    {
        $result = new CategoryRouteDto();
        $result->idCategory= $entity->getIdCategory();
        $result->title = $entity->getTitle();
        $result->description = $entity->getDescription();
        $result->imgCategory = $entity->getImgCategory();
        $result->routes = $this->routeMapper->mapEntitiesToDtoArray($entity->getRoutes());
        return $result;
    }
}
