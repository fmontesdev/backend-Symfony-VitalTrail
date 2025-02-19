<?php

declare(strict_types=1);

namespace App\Routes\Presentation\InputAdapter\Resource;

use App\Routes\Application\Config\RouteConfig;
use App\Routes\Application\Dto\RouteDto;
use App\Routes\Presentation\InputAdapter\Provider\RouteProvider;
use App\Routes\Presentation\InputAdapter\Provider\RoutesProvider;
use App\Routes\Presentation\InputAdapter\Processor\RouteCreateProcessor;
use App\Routes\Presentation\InputAdapter\Processor\RouteUpdateProcessor;
use App\Routes\Presentation\InputAdapter\Processor\RouteDeleteProcessor;
use App\Routes\Presentation\InputAdapter\Processor\FavoriteProcessor;
use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use ApiPlatform\OpenApi\Model\Operation;
use ApiPlatform\OpenApi\Model\Parameter;
use Symfony\Component\PropertyInfo\Type;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    operations: [
        new Get(
            name: 'route_list',
            uriTemplate: '/routes',
            provider: RoutesProvider::class,
            normalizationContext: [
                'groups' => [
                    RouteConfig::OUTPUT_LIST,
                ],
            ],
            openapi: new Operation(
                summary: '',
                description: '',
                parameters: [
                    new Parameter(
                        name: 'category',
                        in: 'query',
                        required: false,
                        schema: ['type' => 'string'],
                    ),
                    new Parameter(
                        name: 'location',
                        in: 'query',
                        required: false,
                        schema: ['type' => 'string'],
                    ),
                    new Parameter(
                        name: 'title',
                        in: 'query',
                        required: false,
                        schema: ['type' => 'string'],
                    ),
                    new Parameter(
                        name: 'distance',
                        in: 'query',
                        required: false,
                        schema: ['type' => 'integer'],
                    ),
                    new Parameter(
                        name: 'difficulty',
                        in: 'query',
                        required: false,
                        schema: ['type' => 'string'],
                    ),
                    new Parameter(
                        name: 'typeRoute',
                        in: 'query',
                        required: false,
                        schema: ['type' => 'string'],
                    ),
                    new Parameter(
                        name: 'author',
                        in: 'query',
                        required: false,
                        schema: ['type' => 'string'],
                    ),
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
        new Get(
            name: 'route_get',
            uriTemplate: '/routes/{slug}',
            provider: RouteProvider::class,
            normalizationContext: [
                'groups' => [
                    RouteConfig::OUTPUT,
                ],
            ],
            openapi: new Operation(
                summary: '',
                description: '',
                parameters: [
                    new Parameter(
                        name: 'slug',
                        in: 'path',
                        required: true,
                        schema: ['type' => 'string'],
                    ),
                ],
            ),
        ),
        new Post(
            name: 'route_create',
            uriTemplate: '/routes',
            processor: RouteCreateProcessor::class,
            normalizationContext: [
                'groups' => [
                    RouteConfig::OUTPUT,
                ],
            ],
            denormalizationContext: [
                'groups' => [
                    RouteConfig::INPUT,
                ],
            ],
            validationContext: [
                'groups' => [
                    RouteConfig::VALID,
                ],
            ],
            openapi: new Operation(
                summary: '',
                description: '',
            ),
        ),
        new Put(
            name: 'route_update',
            uriTemplate: '/routes/{slug}',
            read: false,
            processor: RouteUpdateProcessor::class,
            normalizationContext: [
                'groups' => [
                    RouteConfig::OUTPUT,
                ],
            ],
            denormalizationContext: [
                'groups' => [
                    RouteConfig::INPUT,
                ],
            ],
            validationContext: [
                'groups' => [
                    RouteConfig::VALID,
                ],
            ],
            openapi: new Operation(
                summary: '',
                description: '',
                parameters: [
                    new Parameter(
                        name: 'slug',
                        in: 'path',
                        required: true,
                        schema: ['type' => 'string'],
                    ),
                ],
            ),
        ),
        new Delete(
            name: 'route_delete',
            uriTemplate: '/routes/{slug}',
            processor: RouteDeleteProcessor::class,
            read: false,
            openapi: new Operation(
                summary: '',
                description: '',
                parameters: [
                    new Parameter(
                        name: 'slug',
                        in: 'path',
                        required: true,
                        schema: ['type' => 'string'],
                    ),
                ],
            ),
        ),
        new Post(
            name: 'route_favorite',
            uriTemplate: '/routes/{slug}/favorite',
            processor: FavoriteProcessor::class,
            deserialize: false,
            read: false,
            validate: false,
            normalizationContext: [
                'groups' => [
                    RouteConfig::OUTPUT,
                ],
            ],
            openapi: new Operation(
                summary: '',
                description: '',
                parameters: [
                    new Parameter(
                        name: 'slug',
                        in: 'path',
                        required: true,
                        schema: ['type' => 'string'],
                    ),
                ],
            ),
        ),
        new Delete(
            name: 'route_unfavorite',
            uriTemplate: '/routes/{slug}/unfavorite',
            processor: FavoriteProcessor::class,
            // deserialize: false,
            read: false,
            // validate: false,
            normalizationContext: [
                'groups' => [
                    RouteConfig::OUTPUT,
                ],
            ],
            status: 200,
            openapi: new Operation(
                summary: '',
                description: '',
                parameters: [
                    new Parameter(
                        name: 'slug',
                        in: 'path',
                        required: true,
                        schema: ['type' => 'string'],
                    ),
                ],
            ),
        ),
    ],
)]
final class RouteResource
{
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
    #[Groups([
        RouteConfig::OUTPUT_LIST,
    ])]
    public array $routes = [];

    #[Groups([
        RouteConfig::OUTPUT_LIST,
    ])]
    public int $routesCount = 0;

    #[Assert\Valid]
    #[Groups([
        RouteConfig::INPUT,
        RouteConfig::OUTPUT
    ])]
    public ?RouteDto $route = null;
}
