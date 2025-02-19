<?php

declare(strict_types=1);

namespace App\Routes\Presentation\Mapper;

use App\Routes\Domain\Entity\Route;
use App\Routes\Domain\Enum\DifficultyRouteEnum;
use App\Routes\Domain\Enum\TypeRouteEnum;
use App\Routes\Application\Dto\RouteDto;
use App\Auth\Presentation\Mapper\UserMapper;
// use App\Routes\Presentation\Mapper\CategoryRouteMapper;
use App\Routes\Presentation\Mapper\ImageRouteMapper;
use App\Routes\Presentation\Mapper\CommentMapper;
use App\Routes\Application\Service\FavoriteService;
use App\Routes\Application\Service\RatingService;

class RouteMapper
{
    public function __construct(
        private FavoriteService $favoriteService,
        private RatingService $ratingService,
        private UserMapper $userMapper,
        // private CategoryRouteMapper $categoryRouteMapper,
        private ImageRouteMapper $imageMapper,
        private CommentMapper $commentMapper
    ) {
    }

    public function mapDtoToEntity(RouteDto $dto, ?Route $entity = null): Route
    {
        $result = $entity ?: new Route();
        if ($dto->user !== null) {
            $result->setUser($dto->user);
            // $result->setUser($this->userMapper->mapDtoToEntity($dto->user));
        }
        if ($dto->category !== null) {
            $result->setCategory($dto->category);
        }
        if ($dto->title !== null) {
            $result->setTitle($dto->title);
        }
        if ($dto->description !== null) {
            $result->setDescription($dto->description);
        }
        if ($dto->location !== null) {
            $result->setLocation($dto->location);
        }
        if ($dto->distance !== null) {
            $result->setDistance($dto->distance);
        }
        if ($dto->duration !== null) {
            $result->setDuration($dto->duration);
        }
        if ($dto->difficulty !== null) {
            $result->setDifficulty(DifficultyRouteEnum::from($dto->difficulty));
        }
        if ($dto->typeRoute !== null) {
            $result->setTypeRoute(TypeRouteEnum::from($dto->typeRoute));
        }
        if ($dto->coordinates !== null) {
            $result->setCoordinates($dto->coordinates);
        }
        return $result;
    }

    public function mapEntityToDto(Route $entity, string $response = null): RouteDto
    {
        $result = new RouteDto();
        $result->idRoute= $entity->getIdRoute();
        if ($response === 'getOneRoute' && $entity->getUser() !== null) {
            $result->user = $this->userMapper->mapEntityToDto($entity->getUser());
        }
        if ($response === 'getAllRoute' && $entity->getUser() !== null) {
            $result->user = $entity->getUser()->getIdUser();
        }
        $result->category = $entity->getCategory()->getTitle();
        $result->title = $entity->getTitle();
        $result->location = $entity->getLocation();
        $result->description = $entity->getDescription();
        $result->distance = $entity->getDistance();
        $result->duration = $entity->getDuration();
        $result->difficulty = $entity->getDifficulty()?->value;
        $result->typeRoute = $entity->getTypeRoute()?->value;
        $result->coordinates = $entity->getCoordinates();
        $result->createdAt = $entity->getCreatedAt();
        $result->updatedAt = $entity->getCreatedAt();
        $result->start = $entity->getStart();
        $result->favorited = $this->favoriteService->isFavorited($entity);
        $result->favoritesCount = $this->favoriteService->favoriteCount($entity);
        $result->images = $this->imageMapper->mapEntitiesToDtoArray($entity->getImages());
        if ($response === 'getOneRoute') {
            $result->comments = $this->commentMapper->mapEntitiesToDtoArray($entity->getComments());
        }
        $result->averageRatings = $this->ratingService->averageRatings($entity->getIdRoute());
        $result->slug = $entity->getSlug();
        return $result;
    }

    public function mapEntitiesToDtoArray(iterable $routes, string $response = null): array
    {
        $result = [];
        foreach ($routes as $route) {
            $result[] = $this->mapEntityToDto($route, $response);
        }
        rsort($result);
        return $result;
    }
}
