<?php

declare(strict_types=1);

namespace App\Sessions\Application\Service;

use App\Sessions\Application\Dto\WellbeingCheckinDto;
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
}
