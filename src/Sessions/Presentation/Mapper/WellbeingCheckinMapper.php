<?php

declare(strict_types=1);

namespace App\Sessions\Presentation\Mapper;

use App\Sessions\Application\Dto\WellbeingCheckinDto;
use App\Sessions\Domain\Entity\WellbeingCheckin;

final class WellbeingCheckinMapper
{
    public function mapEntityToDto(WellbeingCheckin $entity): WellbeingCheckinDto
    {
        $dto = new WellbeingCheckinDto();
        $dto->idCheckin = $entity->getIdCheckin();
        $dto->idSession = $entity->getSession()?->getIdSession();
        $dto->energy = $entity->getEnergy();
        $dto->stress = $entity->getStress();
        $dto->mood = $entity->getMood();
        $dto->notes = $entity->getNotes();
        $dto->createAt = $entity->getCreateAt();
        return $dto;
    }

    public function mapDtoToEntity(WellbeingCheckinDto $dto, ?WellbeingCheckin $entity = null): WellbeingCheckin
    {
        $result = $entity ?? new WellbeingCheckin();
        if ($dto->energy !== null) {
            $result->setEnergy($dto->energy);
        }
        if ($dto->stress !== null) {
            $result->setStress($dto->stress);
        }
        if ($dto->mood !== null) {
            $result->setMood($dto->mood);
        }
        if ($dto->notes !== null) {
            $result->setNotes($dto->notes);
        }
        return $result;
    }
}
