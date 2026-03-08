<?php

declare(strict_types=1);

namespace App\Sessions\Presentation\Mapper;

use App\Sessions\Application\Dto\RouteSessionDto;
use App\Sessions\Domain\Entity\RouteSession;

final class RouteSessionMapper
{
    public function mapEntityToDto(RouteSession $entity): RouteSessionDto
    {
        $dto = new RouteSessionDto();
        $dto->idSession = $entity->getIdSession();
        $dto->user = $entity->getUser()?->getIdUser();
        $dto->route = $entity->getRoute()?->getIdRoute();
        $dto->startAt = $entity->getStartAt();
        $dto->endAt = $entity->getEndAt();
        $dto->createAt = $entity->getCreateAt();
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
