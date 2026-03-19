<?php

declare(strict_types=1);

namespace App\Sessions\Presentation\Mapper;

use App\Sessions\Application\Dto\RouteSessionDto;
use App\Sessions\Domain\Entity\RouteSession;

final class RouteSessionMapper
{
    public function __construct(
        private readonly WellbeingCheckinMapper $wellbeingCheckinMapper,
    ) {
    }

    public function mapEntityToDto(RouteSession $entity): RouteSessionDto
    {
        $dto = new RouteSessionDto();
        $dto->idSession = $entity->getIdSession();
        $dto->idUser = $entity->getUser()?->getIdUser();
        $dto->idRoute = $entity->getRoute()?->getIdRoute();
        $dto->slug = $entity->getRoute()?->getSlug();
        $dto->title = $entity->getRoute()?->getTitle();
        $dto->distance = $entity->getDistance();
        $dto->startAt = $entity->getStartAt();
        $dto->endAt = $entity->getEndAt();
        $dto->createdAt = $entity->getCreateAt();

        $checkin = $entity->getWellbeingCheckin();
        $dto->checkin = $checkin !== null
            ? $this->wellbeingCheckinMapper->mapEntityToDto($checkin)
            : null;

        return $dto;
    }

    public function mapDtoToEntity(RouteSessionDto $dto, ?RouteSession $entity = null): RouteSession
    {
        $result = $entity ?? new RouteSession();
        if ($dto->startAt !== null) {
            $result->setStartAt($dto->startAt);
        }
        if ($dto->endAt !== null) {
            $result->setEndAt($dto->endAt);
        }
        return $result;
    }
}
