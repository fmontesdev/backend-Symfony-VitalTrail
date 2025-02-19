<?php

declare(strict_types=1);

namespace App\Routes\Application\Dto;

use App\Auth\Domain\Entity\User;
use App\Routes\Domain\Entity\Route;
use App\Routes\Domain\Entity\Comment;
use App\Routes\Application\Dto\CommentDto;
use App\Routes\Application\Config\RatingConfig;
use App\Routes\Application\Config\CommentConfig;
use App\Shared\Application\Config\DateTimeConfig;
use ApiPlatform\Metadata\ApiProperty;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\Context;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Uid\Uuid;
use DateTimeInterface;

final class RatingDto
{
    #[ApiProperty(identifier: true)]
    #[Groups([
        RatingConfig::OUTPUT,
        RatingConfig::OUTPUT_LIST,
        CommentConfig::OUTPUT,
        CommentConfig::OUTPUT_LIST,
    ])]
    public ?int $idRating = null;
    
    #[ApiProperty(identifier: true)]
    #[Groups([
        RatingConfig::OUTPUT,
        RatingConfig::OUTPUT_LIST,
        CommentConfig::OUTPUT,
        CommentConfig::OUTPUT_LIST,
    ])]
    public User|Uuid|null $user = null;

    #[ApiProperty(identifier: true)]
    #[Groups([
        RatingConfig::OUTPUT,
        RatingConfig::OUTPUT_LIST,
        CommentConfig::OUTPUT,
        CommentConfig::OUTPUT_LIST,
    ])]
    public Route|int|null $route = null;

    #[ApiProperty(identifier: true)]
    #[Groups([
        RatingConfig::OUTPUT,
        RatingConfig::OUTPUT_LIST,
        CommentConfig::OUTPUT,
        CommentConfig::OUTPUT_LIST,
    ])]
    public Comment|string|null $comment = null;

    #[Assert\NotBlank(
        groups: [
            RatingConfig::VALID
        ]
    )]
    #[Groups([
        RatingConfig::INPUT,
        RatingConfig::OUTPUT,
        RatingConfig::OUTPUT_LIST,
        CommentConfig::OUTPUT,
        CommentConfig::OUTPUT_LIST,
    ])]
    public ?int $rating = null;

    #[Context([
        DateTimeNormalizer::FORMAT_KEY => DateTimeConfig::FORMAT,
    ])]
    #[Groups([
        RatingConfig::OUTPUT,
        RatingConfig::OUTPUT_LIST,
        CommentConfig::OUTPUT,
        CommentConfig::OUTPUT_LIST,
    ])]
    public ?DateTimeInterface $createdAt = null;

    #[Groups([
        RatingConfig::INPUT,
    ])]
    public ?string $body = null;
}
