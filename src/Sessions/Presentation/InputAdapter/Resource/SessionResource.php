<?php

declare(strict_types=1);

namespace App\Sessions\Presentation\InputAdapter\Resource;

use App\Sessions\Application\Config\RouteSessionConfig;
use App\Sessions\Application\Config\WellbeingCheckinConfig;
use App\Sessions\Application\Dto\RouteSessionDto;
use App\Sessions\Application\Dto\WellbeingCheckinDto;
use App\Sessions\Presentation\InputAdapter\Processor\CheckinCreateProcessor;
use App\Sessions\Presentation\InputAdapter\Processor\SessionCloseProcessor;
use App\Sessions\Presentation\InputAdapter\Processor\SessionCreateProcessor;
use App\Sessions\Presentation\InputAdapter\Processor\SessionDeleteProcessor;
use App\Sessions\Presentation\InputAdapter\Provider\ActiveSessionProvider;
use App\Sessions\Presentation\InputAdapter\Provider\CheckinProvider;
use App\Sessions\Presentation\InputAdapter\Provider\CheckinsProvider;
use App\Sessions\Presentation\InputAdapter\Provider\SessionProvider;
use App\Sessions\Presentation\InputAdapter\Provider\SessionsProvider;
use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\OpenApi\Model\Operation;
use ApiPlatform\OpenApi\Model\Parameter;
use Symfony\Component\PropertyInfo\Type;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    operations: [
        new Get(
            name: 'session_active',
            uriTemplate: '/sessions/active',
            provider: ActiveSessionProvider::class,
            normalizationContext: [
                'groups' => [
                    RouteSessionConfig::OUTPUT,
                ],
                'skip_null_values' => false,
            ],
            openapi: new Operation(
                summary: '',
                description: '',
            ),
        ),
        new Get(
            name: 'session_get',
            uriTemplate: '/sessions/{id}',
            provider: SessionProvider::class,
            normalizationContext: [
                'groups' => [
                    RouteSessionConfig::OUTPUT,
                ],
                'skip_null_values' => false,
            ],
            openapi: new Operation(
                summary: '',
                description: '',
                parameters: [
                    new Parameter(
                        name: 'id',
                        in: 'path',
                        required: true,
                        schema: ['type' => 'integer'],
                    ),
                ],
            ),
        ),
        new Get(
            name: 'sessions_list',
            uriTemplate: '/sessions',
            provider: SessionsProvider::class,
            normalizationContext: [
                'groups' => [
                    RouteSessionConfig::OUTPUT_LIST,
                ],
                'skip_null_values' => false,
            ],
            openapi: new Operation(
                summary: '',
                description: '',
                parameters: [
                    new Parameter(
                        name: 'limit',
                        in: 'query',
                        required: false,
                        schema: ['type' => 'integer'],
                    ),
                    new Parameter(
                        name: 'offset',
                        in: 'query',
                        required: false,
                        schema: ['type' => 'integer'],
                    ),
                ],
            ),
        ),
        new Post(
            name: 'session_create',
            uriTemplate: '/sessions',
            read: false,
            processor: SessionCreateProcessor::class,
            normalizationContext: [
                'groups' => [
                    RouteSessionConfig::OUTPUT,
                ],
                'skip_null_values' => false,
            ],
            denormalizationContext: [
                'groups' => [
                    RouteSessionConfig::INPUT,
                ],
            ],
            validationContext: [
                'groups' => [
                    RouteSessionConfig::VALID,
                ],
            ],
            openapi: new Operation(
                summary: '',
                description: '',
            ),
        ),
        new Delete(
            name: 'session_delete',
            uriTemplate: '/sessions/{id}',
            processor: SessionDeleteProcessor::class,
            read: false,
            openapi: new Operation(
                summary: '',
                description: '',
                parameters: [
                    new Parameter(
                        name: 'id',
                        in: 'path',
                        required: true,
                        schema: ['type' => 'integer'],
                    ),
                ],
            ),
        ),
        new Patch(
            name: 'session_close',
            uriTemplate: '/sessions/{id}/end',
            read: false,
            inputFormats: ['json' => ['application/json', 'application/merge-patch+json']],
            processor: SessionCloseProcessor::class,
            normalizationContext: [
                'groups' => [
                    RouteSessionConfig::OUTPUT,
                ],
                'skip_null_values' => false,
            ],
            denormalizationContext: [
                'groups' => [
                    RouteSessionConfig::INPUT_CLOSE,
                ],
            ],
            openapi: new Operation(
                summary: '',
                description: '',
                parameters: [
                    new Parameter(
                        name: 'id',
                        in: 'path',
                        required: true,
                        schema: ['type' => 'integer'],
                    ),
                ],
            ),
        ),
        new Post(
            name: 'checkin_create',
            uriTemplate: '/sessions/{id}/checkin',
            read: false,
            processor: CheckinCreateProcessor::class,
            normalizationContext: [
                'groups' => [
                    WellbeingCheckinConfig::OUTPUT,
                ],
            ],
            denormalizationContext: [
                'groups' => [
                    WellbeingCheckinConfig::INPUT,
                ],
            ],
            validationContext: [
                'groups' => [
                    WellbeingCheckinConfig::VALID,
                ],
            ],
            openapi: new Operation(
                summary: '',
                description: '',
                parameters: [
                    new Parameter(
                        name: 'id',
                        in: 'path',
                        required: true,
                        schema: ['type' => 'integer'],
                    ),
                ],
            ),
        ),
        new Get(
            name: 'checkin_get',
            uriTemplate: '/sessions/{id}/checkin',
            provider: CheckinProvider::class,
            normalizationContext: [
                'groups' => [
                    WellbeingCheckinConfig::OUTPUT,
                ],
            ],
            openapi: new Operation(
                summary: '',
                description: '',
                parameters: [
                    new Parameter(
                        name: 'id',
                        in: 'path',
                        required: true,
                        schema: ['type' => 'integer'],
                    ),
                ],
            ),
        ),
        new Get(
            name: 'checkins_list',
            uriTemplate: '/checkins',
            provider: CheckinsProvider::class,
            normalizationContext: [
                'groups' => [
                    WellbeingCheckinConfig::OUTPUT_LIST,
                ],
            ],
            openapi: new Operation(
                summary: '',
                description: '',
            ),
        ),
    ],
)]
final class SessionResource
{
    #[ApiProperty(identifier: true)]
    public ?int $id = null;

    #[Assert\Valid]
    #[Groups([
        RouteSessionConfig::INPUT,
        RouteSessionConfig::INPUT_CLOSE,
        RouteSessionConfig::OUTPUT,
    ])]
    public ?RouteSessionDto $session = null;

    /**
     * @var RouteSessionDto[]
     */
    #[ApiProperty(
        builtinTypes: [
            new Type(
                builtinType: Type::BUILTIN_TYPE_ARRAY,
                collection: true,
                collectionValueType: [
                    new Type(
                        builtinType: Type::BUILTIN_TYPE_OBJECT,
                        class: RouteSessionDto::class,
                    ),
                ],
            ),
        ],
    )]
    #[Groups([
        RouteSessionConfig::OUTPUT_LIST,
    ])]
    public array $sessions = [];

    #[Groups([RouteSessionConfig::OUTPUT_LIST])]
    public int $sessionsCount = 0;

    #[Assert\Valid]
    #[Groups([
        WellbeingCheckinConfig::INPUT,
        WellbeingCheckinConfig::OUTPUT,
    ])]
    public ?WellbeingCheckinDto $checkin = null;

    #[Groups([WellbeingCheckinConfig::OUTPUT_LIST])]
    public array $checkins = [];
}
