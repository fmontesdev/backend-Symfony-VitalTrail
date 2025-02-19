<?php

declare(strict_types=1);

namespace App\Auth\Application\Dto;

use App\Auth\Application\Config\UserConfig;
use App\Routes\Application\Config\RouteConfig;
use App\Profiles\Application\Config\ProfileConfig;
use ApiPlatform\Metadata\ApiProperty;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Uid\Uuid;

final class ClientDto
{
    #[ApiProperty(identifier: true)]
    #[Groups([
        UserConfig::OUTPUT,
        UserConfig::OUTPUT_LOGIN,
        RouteConfig::OUTPUT,
        RouteConfig::OUTPUT_LIST,
    ])]
    public ?int $idClient = null;

    #[Groups([
        UserConfig::OUTPUT,
        UserConfig::OUTPUT_LOGIN,
        RouteConfig::OUTPUT,
        RouteConfig::OUTPUT_LIST,
    ])]
    public UserDto|Uuid|null $user = null;

    #[Assert\Regex(
        pattern: "/^\+?\d{1,4}?[\s-]?(\(?\d{1,4}\)?[\s-]?)?[\d\s-]{5,15}$/i",
        match: true,
        message: 'Number of telephone is not valid',
        groups: [
            UserConfig::VALID_REGISTER,
        ],
    )]
    #[Groups([
        UserConfig::INPUT_REGISTER,
        UserConfig::OUTPUT,
        UserConfig::OUTPUT_LOGIN,
        RouteConfig::OUTPUT,
        RouteConfig::OUTPUT_LIST,
        ProfileConfig::OUTPUT,
        ProfileConfig::OUTPUT_LIST,
    ])]
    public ?string $phone = null;
}
