<?php

declare(strict_types=1);

namespace App\Profiles\Application\Dto;

use App\Auth\Application\Dto\AdminDto;
use App\Auth\Application\Dto\ClientDto;
use App\Profiles\Application\Config\ProfileConfig;
use App\Shared\Application\Config\DateTimeConfig;
use Symfony\Component\Serializer\Annotation\Context;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;

final class ProfileDto
{
    #[Groups([
        ProfileConfig::OUTPUT,
        ProfileConfig::OUTPUT_LIST,
    ])]
    public ?string $email = null;

    #[Groups([
        ProfileConfig::OUTPUT,
        ProfileConfig::OUTPUT_LIST,
    ])]
    public ?string $username = null;

    #[Groups([
        ProfileConfig::OUTPUT,
        ProfileConfig::OUTPUT_LIST,
    ])]
    public ?string $name = null;

    #[Groups([
        ProfileConfig::OUTPUT,
        ProfileConfig::OUTPUT_LIST,
    ])]
    public ?string $surname = null;

    #[Context([
        DateTimeNormalizer::FORMAT_KEY => DateTimeConfig::FORMAT_DATE,
    ])]
    #[Groups([
        ProfileConfig::OUTPUT,
        ProfileConfig::OUTPUT_LIST,
    ])]
    public ?\DateTimeInterface  $birthday = null;

    #[Groups([
        ProfileConfig::OUTPUT,
        ProfileConfig::OUTPUT_LIST,
    ])]
    public ?string $bio = null;

    #[Groups([
        ProfileConfig::OUTPUT,
        ProfileConfig::OUTPUT_LIST,
    ])]
    public ?string $imgUser = null;

    #[Groups([
        ProfileConfig::OUTPUT,
        ProfileConfig::OUTPUT_LIST,
    ])]
    public ?AdminDto $admin = null;

    #[Groups([
        ProfileConfig::OUTPUT,
        ProfileConfig::OUTPUT_LIST,
    ])]
    public ?ClientDto $client = null;

    #[Groups([
        ProfileConfig::OUTPUT,
        ProfileConfig::OUTPUT_LIST,
    ])]
    public bool $following = false;

    #[Groups([
        ProfileConfig::OUTPUT,
        ProfileConfig::OUTPUT_LIST,
    ])]
    public int $countFollowers = 0;

    #[Groups([
        ProfileConfig::OUTPUT,
        ProfileConfig::OUTPUT_LIST,
    ])]
    public int $countFollowings = 0;
}
