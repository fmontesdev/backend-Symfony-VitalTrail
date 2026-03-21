<?php

declare(strict_types=1);

namespace App\Profiles\Presentation\InputAdapter\Resource;

use App\Profiles\Application\Config\ProfileConfig;
use App\Profiles\Application\Dto\ProfileDto;
use App\Profiles\Presentation\InputAdapter\Provider\FavoriteRoutesProvider;
use App\Profiles\Presentation\InputAdapter\Provider\ProfilesProvider;
use App\Profiles\Presentation\InputAdapter\Provider\ProfileProvider;
use App\Profiles\Presentation\InputAdapter\Processor\FollowProcessor;
use App\Profiles\Presentation\InputAdapter\Processor\ProfileAvatarUploadProcessor;
use App\Routes\Application\Config\RouteConfig;
use App\Routes\Application\Dto\RouteDto;
use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\OpenApi\Model\Operation;
use ApiPlatform\OpenApi\Model\Parameter;
use Symfony\Component\PropertyInfo\Type;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiResource(
    operations: [
        new Get(
            name: 'profile_favorite_routes',
            uriTemplate: '/profiles/{username}/favorites',
            provider: FavoriteRoutesProvider::class,
            normalizationContext: [
                'groups' => [ProfileConfig::OUTPUT_FAVORITE_ROUTES, RouteConfig::OUTPUT_LIST],
                'skip_null_values' => false,
            ],
            openapi: new Operation(
                summary: '',
                description: '',
                parameters: [
                    new Parameter(
                        name: 'username',
                        in: 'path',
                        required: true,
                        schema: ['type' => 'string'],
                    ),
                    new Parameter(
                        name: 'limit',
                        in: 'query',
                        required: false,
                        schema: ['type' => 'integer', 'default' => 10],
                    ),
                    new Parameter(
                        name: 'offset',
                        in: 'query',
                        required: false,
                        schema: ['type' => 'integer', 'default' => 0],
                    ),
                ],
            ),
        ),
        new Get(
            name: 'profile_follows_list',
            uriTemplate: '/profiles/{username}/{follows}',
            provider: ProfilesProvider::class,
            normalizationContext: [
                'groups' => [
                    ProfileConfig::OUTPUT_LIST,
                ],
                'skip_null_values' => false,
            ],
            openapi: new Operation(
                summary: '',
                description: '',
                parameters: [
                    new Parameter(
                        name: 'username',
                        in: 'path',
                        required: true,
                        schema: ['type' => 'string'],
                    ),
                    new Parameter(
                        name: 'follows',
                        in: 'path',
                        required: true,
                        schema: ['type' => 'string'],
                    ),
                ],
            ),
        ),
        new Get(
            name: 'profile_get',
            uriTemplate: '/profiles/{username}',
            provider: ProfileProvider::class,
            normalizationContext: [
                'groups' => [
                    ProfileConfig::OUTPUT,
                ],
                'skip_null_values' => false,
            ],
            openapi: new Operation(
                summary: '',
                description: '',
                parameters: [
                    new Parameter(
                        name: 'username',
                        in: 'path',
                        required: true,
                        schema: ['type' => 'string'],
                    ),
                ],
            ),
        ),
        new Put(
            name: 'profile_follow',
            uriTemplate: '/profiles/{username}/follow',
            processor: FollowProcessor::class,
            deserialize: false,
            read: false,
            validate: false,
            normalizationContext: [
                'groups' => [
                    ProfileConfig::OUTPUT,
                ],
            ],
            openapi: new Operation(
                summary: '',
                description: '',
                parameters: [
                    new Parameter(
                        name: 'username',
                        in: 'path',
                        required: true,
                        schema: ['type' => 'string'],
                    ),
                ],
            ),
        ),
        new Delete(
            name: 'profile_unfollow',
            uriTemplate: '/profiles/{username}/unfollow',
            processor: FollowProcessor::class,
            // deserialize: false,
            read: false,
            // validate: false,
            normalizationContext: [
                'groups' => [
                    ProfileConfig::OUTPUT,
                ],
            ],
            status: 200,
            openapi: new Operation(
                summary: '',
                description: '',
                parameters: [
                    new Parameter(
                        name: 'username',
                        in: 'path',
                        required: true,
                        schema: ['type' => 'string'],
                    ),
                ],
            ),
        ),
        new Post(
            name: 'profile_avatar_upload',
            uriTemplate: '/profiles/{username}/avatar',
            read: false,
            deserialize: false,
            status: 200,
            processor: ProfileAvatarUploadProcessor::class,
            normalizationContext: ['groups' => [ProfileConfig::OUTPUT]],
            security: "is_granted('ROLE_CLIENT') or is_granted('ROLE_ADMIN')",
            openapi: new Operation(
                summary: '',
                description: '',
                parameters: [
                    new Parameter(
                        name: 'username',
                        in: 'path',
                        required: true,
                        schema: ['type' => 'string'],
                    ),
                ],
            ),
        ),
    ],
)]
final class ProfileResource
{
    /**
     * @var ProfileDto[]
     */
    #[ApiProperty(
        builtinTypes: [
            new Type(
                builtinType: Type::BUILTIN_TYPE_ARRAY,
                collection: true,
                collectionValueType: [
                    new Type(
                        builtinType: Type::BUILTIN_TYPE_OBJECT,
                        class: ProfileDto::class,
                    ),
                ],
            ),
        ],
    )]
    #[Groups([
        ProfileConfig::OUTPUT_LIST,
    ])]
    public array $profiles = [];

    #[Groups([
        ProfileConfig::OUTPUT_LIST,
    ])]
    public int $profilesCount = 0;

    #[Groups([
        ProfileConfig::OUTPUT,
    ])]
    public ?ProfileDto $profile = null;

    /**
     * @var RouteDto[]
     */
    #[ApiProperty(
        builtinTypes: [
            new Type(
                builtinType: Type::BUILTIN_TYPE_ARRAY,
                collection: true,
                collectionValueType: [
                    new Type(
                        builtinType: Type::BUILTIN_TYPE_OBJECT,
                        class: RouteDto::class,
                    ),
                ],
            ),
        ],
    )]
    #[Groups([ProfileConfig::OUTPUT_FAVORITE_ROUTES])]
    public array $favoriteRoutes = [];

    #[Groups([ProfileConfig::OUTPUT_FAVORITE_ROUTES])]
    public int $favoritesRoutesCount = 0;
}
