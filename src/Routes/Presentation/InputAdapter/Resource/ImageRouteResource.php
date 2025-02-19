<?php

declare(strict_types=1);

namespace App\Routes\Presentation\InputAdapter\Resource;

use App\Routes\Application\Config\ImageRouteConfig;
use App\Routes\Application\Dto\ImageRouteDto;
use App\Routes\Presentation\InputAdapter\Provider\ImagesByRouteProvider;
use App\Routes\Presentation\InputAdapter\Processor\ImageRouteAddProcessor;
use App\Routes\Presentation\InputAdapter\Processor\ImageRouteDeleteProcessor;
use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use ApiPlatform\OpenApi\Model\Operation;
use ApiPlatform\OpenApi\Model\Parameter;
use Symfony\Component\PropertyInfo\Type;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    operations: [
        new Get(
            name: 'image_route_list',
            uriTemplate: '/routes/{idRoute}/images',
            provider: ImagesByRouteProvider::class,
            normalizationContext: [
                'groups' => [
                    ImageRouteConfig::OUTPUT_LIST,
                ],
            ],
            openapi: new Operation(
                summary: '',
                description: '',
                parameters: [
                    new Parameter(
                        name: 'idRoute',
                        in: 'path',
                        required: true,
                        schema: ['type' => 'integer'],
                    ),
                ],
            ),
        ),
        new Post(
            name: 'image_route_add',
            uriTemplate: '/routes/{idRoute}/addImg',
            read: false,
            processor: ImageRouteAddProcessor::class,
            normalizationContext: [
                'groups' => [
                    ImageRouteConfig::OUTPUT_LIST,
                ],
            ],
            denormalizationContext: [
                'groups' => [
                    ImageRouteConfig::INPUT,
                ],
            ],
            validationContext: [
                'groups' => [
                    ImageRouteConfig::VALID,
                ],
            ],
            openapi: new Operation(
                summary: '',
                description: '',
                parameters: [
                    new Parameter(
                        name: 'idRoute',
                        in: 'path',
                        required: true,
                        schema: ['type' => 'integer'],
                    ),
                ],
            ),
        ),
        new Delete(
            name: 'image_route_delete',
            uriTemplate: '/image_route/{idImg}',
            processor: ImageRouteDeleteProcessor::class,
            read: false,
            openapi: new Operation(
                summary: '',
                description: '',
                parameters: [
                    new Parameter(
                        name: 'idImg',
                        in: 'path',
                        required: true,
                        schema: ['type' => 'integer'],
                    ),
                ],
            ),
        ),
    ],
)]
final class ImageRouteResource
{
    /**
     * @var ImageRouteDto[]
     */
    #[ApiProperty(
        builtinTypes: [
            new Type(
                builtinType: Type::BUILTIN_TYPE_ARRAY,
                collection: true,
                collectionValueType: [
                    new Type(
                        builtinType: Type::BUILTIN_TYPE_OBJECT,
                        class: ImageRouteDto::class,
                    ),
                ],
            ),
        ],
    )]
    #[Groups([
        ImageRouteConfig::OUTPUT_LIST,
    ])]
    public array $images = [];

    #[Assert\Valid]
    #[Groups([
        ImageRouteConfig::INPUT,
        ImageRouteConfig::OUTPUT
    ])]
    public ?ImageRouteDto $image = null;
}
