<?php

declare(strict_types=1);

namespace App\Sessions\Application\Dto;

use App\Sessions\Application\Config\RouteSessionConfig;
use App\Shared\Application\Config\DateTimeConfig;
use DateTimeInterface;
use Symfony\Component\Serializer\Annotation\Context;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;

final class RouteSessionDto
{
    #[Groups([RouteSessionConfig::OUTPUT, RouteSessionConfig::OUTPUT_LIST])]
    public ?int $idSession = null;

    #[Groups([RouteSessionConfig::OUTPUT, RouteSessionConfig::OUTPUT_LIST])]
    public mixed $idUser = null;

    #[Groups([RouteSessionConfig::INPUT, RouteSessionConfig::OUTPUT, RouteSessionConfig::OUTPUT_LIST])]
    public ?int $idRoute = null;

    #[Groups([RouteSessionConfig::OUTPUT, RouteSessionConfig::OUTPUT_LIST])]
    public ?string $slug = null;

    #[Groups([RouteSessionConfig::OUTPUT, RouteSessionConfig::OUTPUT_LIST])]
    public ?string $title = null;

    #[Groups([RouteSessionConfig::INPUT_CLOSE, RouteSessionConfig::OUTPUT, RouteSessionConfig::OUTPUT_LIST])]
    public ?int $distance = null;

    #[Context([DateTimeNormalizer::FORMAT_KEY => DateTimeConfig::FORMAT])]
    #[Groups([RouteSessionConfig::INPUT, RouteSessionConfig::OUTPUT, RouteSessionConfig::OUTPUT_LIST])]
    public ?DateTimeInterface $startAt = null;

    #[Context([DateTimeNormalizer::FORMAT_KEY => DateTimeConfig::FORMAT])]
    #[Groups([RouteSessionConfig::INPUT, RouteSessionConfig::OUTPUT, RouteSessionConfig::OUTPUT_LIST])]
    public ?DateTimeInterface $endAt = null;

    #[Context([DateTimeNormalizer::FORMAT_KEY => DateTimeConfig::FORMAT])]
    #[Groups([RouteSessionConfig::OUTPUT, RouteSessionConfig::OUTPUT_LIST])]
    public ?DateTimeInterface $createdAt = null;

    #[Groups([RouteSessionConfig::OUTPUT_LIST])]
    public ?WellbeingCheckinDto $checkin = null;
}
