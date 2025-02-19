<?php

declare(strict_types=1);

namespace App\Routes\Application\Dto;

use App\Routes\Application\Config\RouteConfig;
use App\Routes\Application\Config\CategoryRouteConfig;
use App\Shared\Application\Config\DateTimeConfig;
use App\Auth\Application\Dto\UserDto;
use App\Auth\Domain\Entity\User;
use App\Routes\Application\Dto\CategoryRouteDto;
use App\Routes\Domain\Entity\CategoryRoute;
use ApiPlatform\Metadata\ApiProperty;
use Symfony\Component\Serializer\Annotation\Context;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Uid\Uuid;
use DateTimeInterface;

final class RouteDto
{
    #[ApiProperty(identifier: true)]
    #[Groups([
        RouteConfig::OUTPUT,
        RouteConfig::OUTPUT_LIST,
        CategoryRouteConfig::OUTPUT,
        CategoryRouteConfig::OUTPUT_LIST
    ])]
    public ?int $idRoute = null;
    
    #[ApiProperty(identifier: true)]
    #[Groups([
        RouteConfig::OUTPUT,
        RouteConfig::OUTPUT_LIST,
        CategoryRouteConfig::OUTPUT,
        CategoryRouteConfig::OUTPUT_LIST
    ])]
    public ?string $slug = null;

    #[Assert\Length(
        max: RouteConfig::TITLE_LENGTH,
        groups: [
            RouteConfig::VALID
        ],
    )]
    #[Assert\NotBlank(
        groups: [
            RouteConfig::VALID
        ]
    )]
    #[Groups([
        RouteConfig::INPUT,
        RouteConfig::OUTPUT,
        RouteConfig::OUTPUT_LIST
    ])]
    public ?string $title = null;

    #[Assert\NotBlank(
        groups: [
            RouteConfig::VALID
        ],
    )]
    #[Groups([
        RouteConfig::INPUT,
        RouteConfig::OUTPUT,
        RouteConfig::OUTPUT_LIST
    ])]
    public ?string $description = null;

    #[Assert\Length(
        max: RouteConfig::LOCATION_LENGTH,
        groups: [
            RouteConfig::VALID
        ],
    )]
    #[Assert\NotBlank(
        groups: [
            RouteConfig::VALID
        ],
    )]
    #[Groups([
        RouteConfig::INPUT,
        RouteConfig::OUTPUT,
        RouteConfig::OUTPUT_LIST
    ])]
    public ?string $location = null;

    #[Assert\NotBlank(
        groups: [
            RouteConfig::VALID
        ]
    )]
    #[Groups([
        RouteConfig::INPUT,
        RouteConfig::OUTPUT,
        RouteConfig::OUTPUT_LIST
    ])]
    public ?int $distance = 0;

    #[Assert\NotBlank(
        groups: [
            RouteConfig::VALID
        ]
    )]
    #[Groups([
        RouteConfig::INPUT,
        RouteConfig::OUTPUT,
        RouteConfig::OUTPUT_LIST
    ])]
    public int|string|null $duration = null;

    #[Assert\NotBlank(
        groups: [
            RouteConfig::VALID
        ]
    )]
    #[Groups([
        RouteConfig::INPUT,
        RouteConfig::OUTPUT,
        RouteConfig::OUTPUT_LIST
    ])]
    public ?string $difficulty = null;

    #[Assert\NotBlank(
        groups: [
            RouteConfig::VALID
        ]
    )]
    #[Groups([
        RouteConfig::INPUT,
        RouteConfig::OUTPUT,
        RouteConfig::OUTPUT_LIST
    ])]
    public ?string $typeRoute = null;

    #[Assert\NotBlank(
        groups: [
            RouteConfig::VALID
        ]
    )]
    #[Groups([
        RouteConfig::INPUT,
        RouteConfig::OUTPUT,
        RouteConfig::OUTPUT_LIST
    ])]
    public ?array $coordinates = [];

    #[Context([
        DateTimeNormalizer::FORMAT_KEY => DateTimeConfig::FORMAT,
    ])]
    #[Groups([
        RouteConfig::OUTPUT,
        RouteConfig::OUTPUT_LIST
    ])]
    public ?DateTimeInterface $createdAt = null;

    #[Context([
        DateTimeNormalizer::FORMAT_KEY => DateTimeConfig::FORMAT,
    ])]
    #[Groups([
        RouteConfig::OUTPUT,
        RouteConfig::OUTPUT_LIST
    ])]
    public ?DateTimeInterface $updatedAt = null;

    #[Context([
        DateTimeNormalizer::FORMAT_KEY => DateTimeConfig::FORMAT,
    ])]
    #[Groups([
        RouteConfig::OUTPUT,
        RouteConfig::OUTPUT_LIST
    ])]
    public ?DateTimeInterface $start = null;

    #[Groups([
        RouteConfig::OUTPUT,
        RouteConfig::OUTPUT_LIST
    ])]
    public bool $favorited = false;

    #[Groups([
        RouteConfig::OUTPUT,
        RouteConfig::OUTPUT_LIST
    ])]
    public int $favoritesCount = 0;

    #[Groups([
        RouteConfig::OUTPUT,
        RouteConfig::OUTPUT_LIST,
    ])]
    public CategoryRoute|CategoryRouteDto|string|null $category = null;

    #[Groups([
        RouteConfig::INPUT,
    ])]
    public ?string $categoryTitle = null;

    #[Groups([
        RouteConfig::OUTPUT,
        RouteConfig::OUTPUT_LIST,
    ])]
    public User|UserDto|Uuid|string|null $user = null;

    #[Groups([
        RouteConfig::INPUT,
        RouteConfig::OUTPUT,
        RouteConfig::OUTPUT_LIST,
    ])]
    public array $images = [];

    #[Groups([
        RouteConfig::OUTPUT,
        RouteConfig::OUTPUT_LIST,
    ])]
    public array|null $comments = null;

    #[Groups([
        RouteConfig::OUTPUT,
        RouteConfig::OUTPUT_LIST,
    ])]
    public float $averageRatings = 0;
}
