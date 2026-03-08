<?php

declare(strict_types=1);

namespace App\Sessions\Application\Dto;

use App\Sessions\Application\Config\WellbeingCheckinConfig;
use App\Shared\Application\Config\DateTimeConfig;
use Symfony\Component\Serializer\Annotation\Context;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use DateTimeInterface;

final class WellbeingCheckinDto
{
    #[Groups([WellbeingCheckinConfig::OUTPUT])]
    public ?int $idCheckin = null;

    #[Groups([WellbeingCheckinConfig::OUTPUT])]
    public ?int $idSession = null;

    #[Groups([WellbeingCheckinConfig::INPUT, WellbeingCheckinConfig::OUTPUT])]
    public ?int $energy = null;

    #[Groups([WellbeingCheckinConfig::INPUT, WellbeingCheckinConfig::OUTPUT])]
    public ?int $stress = null;

    #[Groups([WellbeingCheckinConfig::INPUT, WellbeingCheckinConfig::OUTPUT])]
    public ?int $mood = null;

    #[Groups([WellbeingCheckinConfig::INPUT, WellbeingCheckinConfig::OUTPUT])]
    public ?string $notes = null;

    #[Context([DateTimeNormalizer::FORMAT_KEY => DateTimeConfig::FORMAT])]
    #[Groups([WellbeingCheckinConfig::OUTPUT])]
    public ?DateTimeInterface $createAt = null;
}
