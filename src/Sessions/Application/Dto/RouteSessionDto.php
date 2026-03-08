<?php

declare(strict_types=1);

namespace App\Sessions\Application\Dto;

use App\Sessions\Application\Config\RouteSessionConfig;
use App\Shared\Application\Config\DateTimeConfig;
use Symfony\Component\Serializer\Annotation\Context;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use DateTimeInterface;

final class RouteSessionDto
{
    #[Groups([RouteSessionConfig::OUTPUT, RouteSessionConfig::OUTPUT_LIST])]
    public ?int $idSession = null;

    #[Groups([RouteSessionConfig::INPUT])]
    public ?int $idRoute = null;

    #[Groups([RouteSessionConfig::OUTPUT, RouteSessionConfig::OUTPUT_LIST])]
    public mixed $user = null;

    #[Groups([RouteSessionConfig::OUTPUT, RouteSessionConfig::OUTPUT_LIST])]
    public mixed $route = null;

    #[Context([DateTimeNormalizer::FORMAT_KEY => DateTimeConfig::FORMAT])]
    #[Groups([RouteSessionConfig::INPUT, RouteSessionConfig::OUTPUT, RouteSessionConfig::OUTPUT_LIST])]
    public ?DateTimeInterface $startAt = null;

    #[Context([DateTimeNormalizer::FORMAT_KEY => DateTimeConfig::FORMAT])]
    #[Groups([RouteSessionConfig::INPUT, RouteSessionConfig::OUTPUT, RouteSessionConfig::OUTPUT_LIST])]
    public ?DateTimeInterface $endAt = null;

    #[Context([DateTimeNormalizer::FORMAT_KEY => DateTimeConfig::FORMAT])]
    #[Groups([RouteSessionConfig::OUTPUT, RouteSessionConfig::OUTPUT_LIST])]
    public ?DateTimeInterface $createAt = null;
}
