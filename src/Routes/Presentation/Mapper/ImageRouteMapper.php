<?php

declare(strict_types=1);

namespace App\Routes\Presentation\Mapper;

use App\Routes\Domain\Entity\ImageRoute;
use App\Routes\Application\Dto\ImageRouteDto;

class ImageRouteMapper
{
    public function mapDtoToEntity(ImageRouteDto $dto, ?ImageRoute $entity = null): ImageRoute
    {
        $result = $entity ?: new ImageRoute();
        if ($dto->route !== null) {
            $result->setRoute($dto->route);
        }
        if ($dto->imgRoute !== null) {
            $result->setImgRoute($dto->imgRoute);
        }
        return $result;
    }

    public function mapEntityToDto(ImageRoute $entity): ImageRouteDto
    {
        $result = new ImageRouteDto();
        $result->idImg= $entity->getIdImg();
        $result->route = $entity->getRoute()->getIdRoute();
        $result->imgRoute = $entity->getImgRoute();
        return $result;
    }

    /**
     * @param iterable<ImageRoute> $images
     * @return ImageRouteDto[]
     */
    public function mapEntitiesToDtoArray(iterable $images): array
    {
        $result = [];
        foreach ($images as $img) {
            $result[] = $this->mapEntityToDto($img);
        }
        sort($result);
        return $result;
    }
}
