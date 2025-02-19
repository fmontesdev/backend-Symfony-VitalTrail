<?php

declare(strict_types=1);

namespace App\Routes\Application\Service;

use App\Routes\Domain\Entity\ImageRoute;
use App\Routes\Domain\Entity\Route;
use App\Routes\Application\Dto\ImageRouteDto;
use App\Routes\Presentation\Mapper\ImageRouteMapper;
use App\Routes\Domain\OutputPort\ImageRouteRepository;
use App\Routes\Application\Exception\ImageRouteNotFoundException;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class ImageRouteService
{
    public function __construct(
        private readonly ImageRouteRepository $imageRouteRepository,
        private readonly ImageRouteMapper $imageRouteMapper
    ) {
    }

    public function findImageRouteSafe(int $idImg): ?ImageRoute
    {
        $imageRoute = $this->imageRouteRepository->findById($idImg);
        if ($imageRoute === null) {
            throw new ImageRouteNotFoundException($idImg );
        }
        return $imageRoute;
    }

    public function save(string $image, Route $route, ?ImageRoute $imageRoute = null): ImageRoute
    {
        $imgDto = new ImageRouteDto();
        $imgDto->route = $route;
        $imgDto->imgRoute = $image;
        $result = $this->imageRouteMapper->mapDtoToEntity($imgDto, $imageRoute);
        $this->imageRouteRepository->save($result);
        return $result;
    }

    private function saveArray(array $images, Route $route, ?ImageRoute $imageRoute = null): Collection
    {
        $results = new ArrayCollection();
        foreach ($images as $img) {
            $imgDto = new ImageRouteDto();
            $imgDto->imgRoute = $img['imgRoute'];
            $imgDto->route = $route;
            $result = $this->imageRouteMapper->mapDtoToEntity($imgDto, $imageRoute);
            $results->add($result);
            $this->imageRouteRepository->save($result);
        }
        
        return $results;
    }

    public function toDto(ImageRoute $imageRoute): ImageRouteDto
    {
        return $this->imageRouteMapper->mapEntityToDto($imageRoute);
    }

    public function createRouteImages(array $images, Route $route): Collection
    {
        $routeImages = $this->saveArray($images, $route, null);
        return $routeImages;
    }
}