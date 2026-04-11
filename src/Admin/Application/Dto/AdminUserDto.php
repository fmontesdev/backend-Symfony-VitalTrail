<?php

declare(strict_types=1);

namespace App\Admin\Application\Dto;

use App\Admin\Application\Config\AdminConfig;
use Symfony\Component\Serializer\Annotation\Context;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;

final class AdminUserDto
{
    #[Groups([AdminConfig::USERS_OUTPUT])]
    public ?string $idUser = null;

    #[Groups([AdminConfig::USERS_OUTPUT])]
    public ?string $username = null;

    #[Groups([AdminConfig::USERS_OUTPUT])]
    public ?string $email = null;

    #[Groups([AdminConfig::USERS_OUTPUT])]
    public ?string $name = null;

    #[Groups([AdminConfig::USERS_OUTPUT])]
    public ?string $surname = null;

    #[Groups([AdminConfig::USERS_OUTPUT])]
    public ?string $imgUser = null;

    #[Groups([AdminConfig::USERS_OUTPUT])]
    public ?string $rol = null;

    #[Groups([AdminConfig::USERS_OUTPUT])]
    public ?bool $isPremium = null;

    #[Groups([AdminConfig::USERS_OUTPUT])]
    public ?bool $isActive = null;

    #[Groups([AdminConfig::USERS_OUTPUT])]
    public ?bool $isDeleted = null;

    #[Context([DateTimeNormalizer::FORMAT_KEY => \DateTimeInterface::ATOM])]
    #[Groups([AdminConfig::USERS_OUTPUT])]
    public ?\DateTimeImmutable $createdAt = null;
}
