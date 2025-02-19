<?php

declare(strict_types=1);

namespace App\Routes\Application\Service;

use App\Routes\Domain\Entity\Rating;
use App\Routes\Domain\Entity\Comment;
use App\Routes\Domain\Entity\Route;
use App\Auth\Domain\Entity\User;
use App\Routes\Application\Dto\RatingDto;
use App\Routes\Presentation\Mapper\RatingMapper;
use App\Routes\Domain\OutputPort\RatingRepository;
use App\Routes\Application\Exception\RatingNotFoundException;
use App\Security\Application\SecurityContext;
use App\Security\Application\AuthorizationService;

class RatingService
{
    public function __construct(
        private readonly RatingRepository $ratingRepository,
        private readonly RatingMapper $ratingMapper,
        private readonly SecurityContext $securityContext,
        private readonly AuthorizationService $authorizationService
    ) {
    }

    public function findRatingSafe(int $idRating): ?Rating
    {
        $comment = $this->ratingRepository->findById($idRating);
        if ($comment === null) {
            throw new RatingNotFoundException($idRating );
        }
        return $comment;
    }

    public function isAuthorized(Rating $entity): bool
    {
        return $this->authorizationService->isOwner($entity) || $this->securityContext->isAdmin() ? true : false;
    }

    public function averageRatings(int $idRoute): float
    {
        return $this->ratingRepository->averageRatings( $idRoute);
    }

    public function save(int $rating, User $user, Route $route, Comment $comment = null, ?Rating $entity = null): Rating
    {
        $ratingDto = new RatingDto();
        $ratingDto->user = $user;
        $ratingDto->route = $route;
        $ratingDto->comment = $comment;
        $ratingDto->rating = $rating;
        $result = $this->ratingMapper->mapDtoToEntity($ratingDto, $entity);
        $this->ratingRepository->save($result);
        return $result;
    }

    public function toDto(Rating $entity): RatingDto
    {
        return $this->ratingMapper->mapEntityToDto($entity);
    }
}
