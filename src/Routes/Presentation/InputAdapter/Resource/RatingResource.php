<?php

declare(strict_types=1);

namespace App\Routes\Presentation\InputAdapter\Resource;

use App\Routes\Application\Config\RatingConfig;
use App\Routes\Application\Dto\RatingDto;
use App\Routes\Application\Dto\CommentDto;
use App\Routes\Presentation\InputAdapter\Provider\RatingsByRouteProvider;
use App\Routes\Presentation\InputAdapter\Processor\RatingCreateProcessor;
use App\Routes\Presentation\InputAdapter\Processor\RatingDeleteProcessor;
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
            name: 'rating_list',
            uriTemplate: '/routes/{slug}/ratings',
            provider: RatingsByRouteProvider::class,
            normalizationContext: [
                'groups' => [
                    RatingConfig::OUTPUT_LIST,
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
            name: 'rating_create',
            uriTemplate: '/routes/{slug}/ratings',
            read: false,
            processor: RatingCreateProcessor::class,
            normalizationContext: [
                'groups' => [
                    RatingConfig::OUTPUT_COMMENT_LIST,
                ],
            ],
            denormalizationContext: [
                'groups' => [
                    RatingConfig::INPUT,
                ],
            ],
            validationContext: [
                'groups' => [
                    RatingConfig::VALID,
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
            name: 'rating_delete',
            uriTemplate: '/routes/{slug}/ratings/{id}',
            processor: RatingDeleteProcessor::class,
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
                    new Parameter(
                        name: 'id',
                        in: 'path',
                        required: true,
                        schema: ['type' => 'integer'],
                    ),
                ],
            ),
        ),
    ],
)]
final class RatingResource
{
    /**
     * @var RatingDto[]
     */
    #[ApiProperty(
        builtinTypes: [
            new Type(
                builtinType: Type::BUILTIN_TYPE_ARRAY,
                collection: true,
                collectionValueType: [
                    new Type(
                        builtinType: Type::BUILTIN_TYPE_OBJECT,
                        class: RatingDto::class,
                    ),
                ],
            ),
        ],
    )]
    #[Groups([
        RatingConfig::OUTPUT_LIST,
    ])]
    public array $ratings = [];

    /**
     * @var CommentDto[]
     */
    #[ApiProperty(
        builtinTypes: [
            new Type(
                builtinType: Type::BUILTIN_TYPE_ARRAY,
                collection: true,
                collectionValueType: [
                    new Type(
                        builtinType: Type::BUILTIN_TYPE_OBJECT,
                        class: CommentDto::class,
                    ),
                ],
            ),
        ],
    )]
    #[Groups([
        RatingConfig::OUTPUT_COMMENT_LIST
    ])]
    public array $comments = [];

    #[Groups([
        RatingConfig::OUTPUT_LIST,
        RatingConfig::OUTPUT_COMMENT_LIST
    ])]
    public float $averageRatings = 0;

    #[Assert\Valid]
    #[Groups([
        RatingConfig::INPUT,
        RatingConfig::OUTPUT
    ])]
    public ?RatingDto $rating = null;
}
