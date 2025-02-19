<?php

declare(strict_types=1);

namespace App\Routes\Application\Dto;

use App\Auth\Domain\Entity\User;
use App\Auth\Application\Dto\UserDto;
use App\Routes\Domain\Entity\Route;
use App\Routes\Application\Config\CommentConfig;
use App\Routes\Application\Config\RatingConfig;
use App\Routes\Application\Config\RouteConfig;
use App\Shared\Application\Config\DateTimeConfig;
use ApiPlatform\Metadata\ApiProperty;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\Context;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Uid\Uuid;
use DateTimeInterface;

final class CommentDto
{
    #[ApiProperty(identifier: true)]
    #[Groups([
        CommentConfig::OUTPUT,
        CommentConfig::OUTPUT_LIST,
        CommentConfig::OUTPUT_PROFILE_LIST,
        RatingConfig::OUTPUT,
        RatingConfig::OUTPUT_LIST,
        RouteConfig::OUTPUT,
        RouteConfig::OUTPUT_LIST,
    ])]
    public ?int $idComment = null;
    
    #[ApiProperty(identifier: true)]
    #[Groups([
        CommentConfig::OUTPUT,
        CommentConfig::OUTPUT_LIST,
        CommentConfig::OUTPUT_PROFILE_LIST,
        RatingConfig::OUTPUT,
        RatingConfig::OUTPUT_LIST,
        RouteConfig::OUTPUT,
        RouteConfig::OUTPUT_LIST,
    ])]
    public User|UserDto|Uuid|null $user = null;

    #[ApiProperty(identifier: true)]
    #[Groups([
        CommentConfig::OUTPUT,
        CommentConfig::OUTPUT_LIST,
        CommentConfig::OUTPUT_PROFILE_LIST,
        RatingConfig::OUTPUT,
        RatingConfig::OUTPUT_LIST,
        RouteConfig::OUTPUT,
        RouteConfig::OUTPUT_LIST,
    ])]
    public Route|int|null $route = null;

    #[Assert\NotBlank(
        groups: [
            CommentConfig::VALID
        ]
    )]
    #[Groups([
        CommentConfig::INPUT,
        CommentConfig::OUTPUT,
        CommentConfig::OUTPUT_LIST,
        CommentConfig::OUTPUT_PROFILE_LIST,
        RatingConfig::OUTPUT,
        RatingConfig::OUTPUT_LIST,
        RouteConfig::OUTPUT,
        RouteConfig::OUTPUT_LIST,
    ])]
    public ?string $body = null;

    #[Groups([
        CommentConfig::OUTPUT,
        CommentConfig::OUTPUT_LIST,
        CommentConfig::OUTPUT_PROFILE_LIST,
        RatingConfig::OUTPUT,
        RatingConfig::OUTPUT_LIST,
        RouteConfig::OUTPUT,
        RouteConfig::OUTPUT_LIST,
    ])]
    public ?int $rating = null;

    #[Context([
        DateTimeNormalizer::FORMAT_KEY => DateTimeConfig::FORMAT,
    ])]
    #[Groups([
        CommentConfig::OUTPUT,
        CommentConfig::OUTPUT_LIST,
        CommentConfig::OUTPUT_PROFILE_LIST,
        RatingConfig::OUTPUT,
        RatingConfig::OUTPUT_LIST,
        RouteConfig::OUTPUT,
        RouteConfig::OUTPUT_LIST,
    ])]
    public ?DateTimeInterface $createdAt = null;
}
