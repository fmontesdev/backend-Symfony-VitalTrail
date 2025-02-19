<?php

declare(strict_types=1);

namespace App\Auth\Application\Dto;

use App\Auth\Application\Config\RefreshTokenConfig;
use ApiPlatform\Metadata\ApiProperty;
use App\Validator as AppAssert;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

final class RefreshTokenDto
{
    #[ApiProperty(identifier: true)]
    #[Groups([
        RefreshTokenConfig::OUTPUT
    ])]
    public ?int $id = null;

    // #[AppAssert\UniqueToken(
    //     groups: [
    //         UserConfig::VALID_REGISTER
    //     ],
    // )]
    #[Assert\NotBlank(
        groups: [
            RefreshTokenConfig::VALID
        ],
    )]
    #[Groups([
        RefreshTokenConfig::INPUT,
        RefreshTokenConfig::OUTPUT
    ])]
    public ?string $refreshToken = null;

    // #[AppAssert\UniqueUsername(
    //     groups: [
    //         UserConfig::VALID_REGISTER
    //     ],
    // )]
    #[Assert\Length(
        max: RefreshTokenConfig::USERNAME_LENGTH,
        groups: [
            RefreshTokenConfig::VALID
        ],
    )]
    #[Assert\NotBlank(
        groups: [
            RefreshTokenConfig::VALID
        ],
    )]
    #[Groups([
        RefreshTokenConfig::INPUT,
        RefreshTokenConfig::OUTPUT
    ])]
    public ?string $username = null;

    #[Groups([
        RefreshTokenConfig::INPUT,
        RefreshTokenConfig::OUTPUT
    ])]
    public ?\DateTimeInterface $valid = null;

    #[Groups([
        RefreshTokenConfig::OUTPUT
    ])]
    public ?bool $isValid = null;
}
