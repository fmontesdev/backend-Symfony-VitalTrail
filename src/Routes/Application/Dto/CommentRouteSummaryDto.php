<?php

declare(strict_types=1);

namespace App\Routes\Application\Dto;

use App\Routes\Application\Config\CommentConfig;
use Symfony\Component\Serializer\Annotation\Groups;

final class CommentRouteSummaryDto
{
    #[Groups([
        CommentConfig::OUTPUT_PROFILE_LIST,
    ])]
    public ?int $id = null;

    #[Groups([
        CommentConfig::OUTPUT_PROFILE_LIST,
    ])]
    public ?string $slug = null;

    #[Groups([
        CommentConfig::OUTPUT_PROFILE_LIST,
    ])]
    public ?string $title = null;

    #[Groups([
        CommentConfig::OUTPUT_PROFILE_LIST,
    ])]
    public ?string $location = null;

    #[Groups([
        CommentConfig::OUTPUT_PROFILE_LIST,
    ])]
    public ?int $distance = null;

    #[Groups([
        CommentConfig::OUTPUT_PROFILE_LIST,
    ])]
    public int|string|null $duration = null;

    #[Groups([
        CommentConfig::OUTPUT_PROFILE_LIST,
    ])]
    public ?string $difficulty = null;

    #[Groups([
        CommentConfig::OUTPUT_PROFILE_LIST,
    ])]
    public ?string $typeRoute = null;

    #[Groups([
        CommentConfig::OUTPUT_PROFILE_LIST,
    ])]
    public ?string $category = null;
}
