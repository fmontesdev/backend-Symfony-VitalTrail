<?php

declare(strict_types=1);

namespace App\Sessions\Application\Service;

use App\Sessions\Application\Dto\WellbeingCheckinDto;
use App\Sessions\Application\Exception\CheckinNotFoundException;
use App\Sessions\Domain\Entity\WellbeingCheckin;
use App\Sessions\Domain\OutputPort\WellbeingCheckinRepository;
use App\Sessions\Presentation\Mapper\WellbeingCheckinMapper;

final class WellbeingCheckinService
{
    public function __construct(
        private readonly WellbeingCheckinRepository $wellbeingCheckinRepository,
        private readonly WellbeingCheckinMapper $wellbeingCheckinMapper,
    ) {
    }

    public function toDto(WellbeingCheckin $checkin): WellbeingCheckinDto
    {
        return $this->wellbeingCheckinMapper->mapEntityToDto($checkin);
    }

    public function findCheckinBySessionSafe(int $idSession): WellbeingCheckin
    {
        $checkin = $this->wellbeingCheckinRepository->findBySession($idSession);
        if ($checkin === null) {
            throw new CheckinNotFoundException($idSession);
        }
        return $checkin;
    }
}
