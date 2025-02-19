<?php

declare(strict_types=1);

namespace App\Routes\Application\Dto;

// use App\Routes\Domain\Entity\Route;
use App\Routes\Application\Config\CategoryRouteConfig;
use ApiPlatform\Metadata\ApiProperty;
use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\Common\Collections\Collection;

final class CategoryRouteDto
{
    #[ApiProperty(identifier: true)]
    #[Groups([
        CategoryRouteConfig::OUTPUT,
        CategoryRouteConfig::OUTPUT_LIST,
    ])]
    public ?int $idCategory = null;

    #[Groups([
        CategoryRouteConfig::OUTPUT,
        CategoryRouteConfig::OUTPUT_LIST,
    ])]
    public ?string $title = null;

    #[Groups([
        CategoryRouteConfig::OUTPUT,
        CategoryRouteConfig::OUTPUT_LIST,
    ])]
    public ?string $imgCategory = null;

    #[Groups([
        CategoryRouteConfig::OUTPUT,
        CategoryRouteConfig::OUTPUT_LIST,
    ])]
    public ?string $description = null;

    #[Groups([
        CategoryRouteConfig::OUTPUT,
        CategoryRouteConfig::OUTPUT_LIST,
    ])]
    public array $routes = [];
}
