<?php

declare(strict_types=1);

namespace App\Auth\Application\Dto;

use App\Auth\Application\Config\UserConfig;
use App\Routes\Application\Config\RouteConfig;
use ApiPlatform\Metadata\ApiProperty;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Uid\Uuid;

final class AdminDto
{
    #[ApiProperty(identifier: true)]
    #[Groups([
        UserConfig::OUTPUT_LOGIN,
        UserConfig::OUTPUT,
        RouteConfig::OUTPUT,
        RouteConfig::OUTPUT_LIST,
    ])]
    public ?int $idAdmin = null;

    #[Groups([
        UserConfig::OUTPUT_LOGIN,
        UserConfig::OUTPUT,
        RouteConfig::OUTPUT,
        RouteConfig::OUTPUT_LIST,
    ])]
    public UserDto|Uuid|null $user = null;
}
