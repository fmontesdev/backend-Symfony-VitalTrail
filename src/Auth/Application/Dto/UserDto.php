<?php

declare(strict_types=1);

namespace App\Auth\Application\Dto;

use App\Auth\Application\Config\UserConfig;
use App\Routes\Application\Config\RouteConfig;
use App\Routes\Application\Config\CommentConfig;
use App\Shared\Application\Config\DateTimeConfig;
use ApiPlatform\Metadata\ApiProperty;
use App\Auth\Domain\Validator as AppAssert;
use Symfony\Component\Serializer\Annotation\Context;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Uid\Uuid;

final class UserDto
{
    #[ApiProperty(identifier: true)]
    #[Groups([
        UserConfig::OUTPUT_LOGIN,
        UserConfig::OUTPUT,
        RouteConfig::OUTPUT,
        RouteConfig::OUTPUT_LIST,
        CommentConfig::OUTPUT,
        CommentConfig::OUTPUT_LIST,
        CommentConfig::OUTPUT_PROFILE_LIST,
    ])]
    public ?Uuid $idUser = null;

    #[AppAssert\UniqueEmail(
        groups: [
            UserConfig::VALID_REGISTER,
        ],
    )]
    #[Assert\Email(
        groups: [
            UserConfig::VALID_REGISTER,
            UserConfig::VALID_LOGIN,
        ],
    )]
    #[Assert\Length(
        max: UserConfig::EMAIL_LENGTH,
        groups: [
            UserConfig::VALID_REGISTER,
            UserConfig::VALID_LOGIN,
        ],
    )]
    #[Assert\NotBlank(
        groups: [
            UserConfig::VALID_REGISTER,
            UserConfig::VALID_LOGIN,
        ],
    )]
    #[Groups([
        UserConfig::INPUT_REGISTER,
        UserConfig::INPUT_LOGIN,
        UserConfig::OUTPUT_LOGIN,
        UserConfig::OUTPUT,
    ])]
    public ?string $email = null;

    #[AppAssert\UniqueUsername(
        groups: [
            UserConfig::VALID_REGISTER,
        ],
    )]
    #[Assert\Regex(
        pattern: "/^[a-z_0-9]+$/i",
        match: true,
        message: 'Username can contain only letters, numbers and underscore',
        groups: [
            UserConfig::VALID_REGISTER,
        ],
    )]
    #[Assert\Length(
        max: UserConfig::USERNAME_LENGTH,
        groups: [
            UserConfig::VALID_REGISTER,
        ],
    )]
    #[Assert\NotBlank(
        groups: [
            UserConfig::VALID_REGISTER,
        ],
    )]
    #[Groups([
        UserConfig::INPUT_REGISTER,
        UserConfig::OUTPUT_LOGIN,
        UserConfig::OUTPUT,
        RouteConfig::OUTPUT,
        RouteConfig::OUTPUT_LIST,
        CommentConfig::OUTPUT,
        CommentConfig::OUTPUT_LIST,
        CommentConfig::OUTPUT_PROFILE_LIST,
    ])]
    public ?string $username = null;

    #[Assert\NotBlank(
        groups: [
            UserConfig::VALID_REGISTER,
            UserConfig::VALID_LOGIN,
        ],
    )]
    #[Groups([
        UserConfig::INPUT_REGISTER,
        UserConfig::INPUT_LOGIN,
        UserConfig::INPUT_UPDATE,
    ])]
    public ?string $password = null;

    #[Groups([
        UserConfig::OUTPUT_LOGIN,
    ])]
    public ?string $token = null;

    #[Groups([
        UserConfig::OUTPUT_LOGIN,
    ])]
    public $refreshToken = null;

    #[Assert\Length(
        max: UserConfig::NAME_LENGTH,
        groups: [
            UserConfig::VALID_REGISTER,
            UserConfig::VALID_UPDATE,
        ],
    )]
    #[Groups([
        UserConfig::INPUT_REGISTER,
        UserConfig::INPUT_UPDATE,
        UserConfig::OUTPUT_LOGIN,
        UserConfig::OUTPUT,
        RouteConfig::OUTPUT,
        RouteConfig::OUTPUT_LIST,
        CommentConfig::OUTPUT,
        CommentConfig::OUTPUT_LIST,
        CommentConfig::OUTPUT_PROFILE_LIST,
    ])]
    public ?string $name = null;

    #[Assert\Length(
        max: UserConfig::SURNAME_LENGTH,
        groups: [
            UserConfig::VALID_REGISTER,
            UserConfig::VALID_UPDATE,
        ],
    )]
    #[Groups([
        UserConfig::INPUT_REGISTER,
        UserConfig::INPUT_UPDATE,
        UserConfig::OUTPUT_LOGIN,
        UserConfig::OUTPUT,
        RouteConfig::OUTPUT,
        RouteConfig::OUTPUT_LIST,
        CommentConfig::OUTPUT,
        CommentConfig::OUTPUT_LIST,
        CommentConfig::OUTPUT_PROFILE_LIST,
    ])]
    public ?string $surname = null;

    #[Context([
        DateTimeNormalizer::FORMAT_KEY => DateTimeConfig::FORMAT_DATE,
    ])]
    #[Groups([
        UserConfig::INPUT_REGISTER,
        UserConfig::INPUT_UPDATE,
        UserConfig::OUTPUT_LOGIN,
        UserConfig::OUTPUT,
    ])]
    public ?\DateTimeInterface  $birthday = null;

    #[Assert\Length(
        max: UserConfig::BIO_LENGTH,
        groups: [
            UserConfig::VALID_REGISTER,
            UserConfig::VALID_UPDATE,
        ],
    )]
    #[Groups([
        UserConfig::INPUT_REGISTER,
        UserConfig::INPUT_UPDATE,
        UserConfig::OUTPUT_LOGIN,
        UserConfig::OUTPUT,
    ])]
    public ?string $bio = null;

    #[Assert\Length(
        max: UserConfig::IMAGE_LENGTH,
        groups: [
            UserConfig::VALID_REGISTER,
            UserConfig::VALID_UPDATE,
        ],
    )]
    #[Groups([
        UserConfig::INPUT_REGISTER,
        UserConfig::OUTPUT_LOGIN,
        UserConfig::OUTPUT,
        RouteConfig::OUTPUT,
        RouteConfig::OUTPUT_LIST,
        CommentConfig::OUTPUT,
        CommentConfig::OUTPUT_LIST,
        CommentConfig::OUTPUT_PROFILE_LIST,
    ])]
    public ?string $imgUser = null;

    #[Groups([
        UserConfig::INPUT_REGISTER,
        UserConfig::OUTPUT_LOGIN,
        UserConfig::OUTPUT,
    ])]
    public ?string $rol = null;

    #[Groups([
        UserConfig::INPUT_UPDATE,
        UserConfig::OUTPUT_LOGIN,
        UserConfig::OUTPUT,
    ])]
    public ?bool $isActive = null;

    #[Groups([
        UserConfig::INPUT_UPDATE,
        UserConfig::OUTPUT_LOGIN,
        UserConfig::OUTPUT,
    ])]
    public ?bool $isDeleted = null;

    #[Groups([
        UserConfig::INPUT_UPDATE,
        UserConfig::OUTPUT_LOGIN,
        UserConfig::OUTPUT,
    ])]
    public ?bool $isPremium = null;

    #[Groups([
        UserConfig::INPUT_REGISTER,
        UserConfig::INPUT_UPDATE,
        UserConfig::OUTPUT_LOGIN,
        UserConfig::OUTPUT,
    ])]
    public ?AdminDto $admin = null;

    #[Groups([
        UserConfig::INPUT_REGISTER,
        UserConfig::INPUT_UPDATE,
        UserConfig::OUTPUT_LOGIN,
        UserConfig::OUTPUT,
    ])]
    public ?ClientDto $client = null;
}
