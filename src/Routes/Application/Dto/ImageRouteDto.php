<?php

declare(strict_types=1);

namespace App\Routes\Application\Dto;

use App\Routes\Domain\Entity\Route;
use App\Routes\Application\Config\RouteConfig;
use App\Routes\Application\Config\ImageRouteConfig;
use ApiPlatform\Metadata\ApiProperty;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

final class ImageRouteDto
{
    #[ApiProperty(identifier: true)]
    #[Groups([
        ImageRouteConfig::OUTPUT,
        ImageRouteConfig::OUTPUT_LIST,
        RouteConfig::OUTPUT,
        RouteConfig::OUTPUT_LIST,
    ])]
    public ?int $idImg = null;
    
    #[ApiProperty(identifier: true)]
    #[Groups([
        ImageRouteConfig::OUTPUT,
        ImageRouteConfig::OUTPUT_LIST,
        RouteConfig::OUTPUT,
        RouteConfig::OUTPUT_LIST,
    ])]
    public Route|int|null $route = null;

    #[Assert\Length(
        max: ImageRouteConfig::IMG_ROUTE_LENGTH,
        groups: [
            ImageRouteConfig::VALID
        ],
    )]
    #[Assert\NotBlank(
        groups: [
            ImageRouteConfig::VALID
        ]
    )]
    #[Groups([
        ImageRouteConfig::INPUT,
        ImageRouteConfig::OUTPUT,
        ImageRouteConfig::OUTPUT_LIST,
        RouteConfig::OUTPUT,
        RouteConfig::OUTPUT_LIST,
    ])]
    public ?string $imgRoute = null;
}
