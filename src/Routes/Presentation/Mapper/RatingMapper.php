<?php

declare(strict_types=1);

namespace App\Routes\Presentation\Mapper;

use App\Routes\Domain\Entity\Rating;
use App\Routes\Application\Dto\RatingDto;
use App\Routes\Presentation\Mapper\CommentMapper;

class RatingMapper
{
    public function __construct(
        private CommentMapper $commentMapper
    ) {}

    public function mapDtoToEntity(RatingDto $dto, ?Rating $entity = null): Rating
    {
        $result = $entity ?: new Rating();
        if ($dto->user !== null) {
            $result->setUser($dto->user);
        }
        if ($dto->route !== null) {
            $result->setRoute($dto->route);
        }
        if ($dto->comment !== null) {
            $result->setComment($dto->comment);
        }
        if ($dto->rating !== null) {
            $result->setRating($dto->rating);
        }
        return $result;
    }

    public function mapEntityToDto(Rating $entity): RatingDto
    {
        $result = new RatingDto();
        $result->idRating= $entity->getIdRating();
        $result->user = $entity->getUser()->getIdUser();
        $result->route = $entity->getRoute()->getIdRoute();
        $entity->getComment() !== null ? $result->comment = $this->commentMapper->mapEntityToDto($entity->getComment())->body : null;
        $result->rating = $entity->getRating();
        $result->createdAt = $entity->getCreatedAt();
        return $result;
    }
}
