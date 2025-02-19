<?php

declare(strict_types=1);

namespace App\Profiles\Presentation\InputAdapter\Resource;

use App\Profiles\Application\Config\ProfileConfig;
use App\Profiles\Application\Dto\ProfileDto;
use App\Profiles\Presentation\InputAdapter\Provider\ProfilesProvider;
use App\Profiles\Presentation\InputAdapter\Provider\ProfileProvider;
use App\Profiles\Presentation\InputAdapter\Processor\FollowProcessor;
use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\OpenApi\Model\Operation;
use ApiPlatform\OpenApi\Model\Parameter;
use Symfony\Component\PropertyInfo\Type;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiResource(
    operations: [
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
                'skip_null_values' => true,
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
}
