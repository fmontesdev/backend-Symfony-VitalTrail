<?php

declare(strict_types=1);

namespace App\Auth\Presentation\InputAdapter\Resource;

use App\Auth\Application\Config\UserConfig;
use App\Auth\Application\Dto\UserDto;
use App\Auth\Presentation\InputAdapter\Processor\UserRegisterProcessor;
use App\Auth\Presentation\InputAdapter\Processor\UserLoginProcessor;
use App\Auth\Presentation\InputAdapter\Processor\UserUpdateProcessor;
use App\Auth\Presentation\InputAdapter\Provider\UserCurrentProvider;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use ApiPlatform\OpenApi\Model\Operation;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    operations: [
        new Post(
            name: 'user_register',
            uriTemplate: '/users/register',
            processor: UserRegisterProcessor::class,
            normalizationContext: [
                'groups' => [
                    UserConfig::OUTPUT,
                ],
                'skip_null_values' => false,
            ],
            denormalizationContext: [
                'groups' => [
                    UserConfig::INPUT_REGISTER,
                ],
            ],
            validationContext: [
                'groups' => [
                    UserConfig::VALID_REGISTER,
                ]
            ],
            openapi: new Operation(
                summary: '',
                description: '',
            ),
        ),
        new Post(
            name: 'user_login',
            uriTemplate: '/users/login',
            processor: UserLoginProcessor::class,
            normalizationContext: [
                'groups' => [
                    UserConfig::OUTPUT_LOGIN,
                ],
                'skip_null_values' => false,
            ],
            denormalizationContext: [
                'groups' => [
                    UserConfig::INPUT_LOGIN,
                ],
            ],
            validationContext: [
                'groups' => [
                    UserConfig::VALID_LOGIN,
                ],
            ],
            openapi: new Operation(
                summary: '',
                description: '',
            ),
        ),
        new Get(
            name: 'user_current',
            uriTemplate: '/user',
            provider: UserCurrentProvider::class,
            normalizationContext: [
                'groups' => [
                    UserConfig::OUTPUT,
                ],
                'skip_null_values' => false,
            ],
            openapi: new Operation(
                summary: '',
                description: '',
            ),
        ),
        new Put(
            name: 'user_update',
            uriTemplate: '/user',
            processor: UserUpdateProcessor::class,
            normalizationContext: [
                'groups' => [
                    UserConfig::OUTPUT,
                ],
                'skip_null_values' => false,
            ],
            denormalizationContext: [
                'groups' => [
                    UserConfig::INPUT_UPDATE,
                ],
            ],
            validationContext: [
                'groups' => [
                    UserConfig::VALID_UPDATE,
                ],
            ],
            openapi: new Operation(
                summary: '',
                description: '',
            ),
        ),
    ],
)]
final class UserResource
{
    #[Assert\Valid]
    #[Groups([
        UserConfig::INPUT_REGISTER,
        UserConfig::INPUT_LOGIN,
        UserConfig::INPUT_UPDATE,
        UserConfig::OUTPUT_LOGIN,
        UserConfig::OUTPUT,
    ])]
    public ?UserDto $user = null;
}
