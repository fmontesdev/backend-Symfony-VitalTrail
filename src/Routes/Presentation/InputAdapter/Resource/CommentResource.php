<?php

declare(strict_types=1);

namespace App\Routes\Presentation\InputAdapter\Resource;

use App\Routes\Application\Config\CommentConfig;
use App\Routes\Application\Dto\CommentDto;
use App\Routes\Presentation\InputAdapter\Provider\CommentsByRouteProvider;
use App\Routes\Presentation\InputAdapter\Provider\CommentsByUserProvider;
use App\Routes\Presentation\InputAdapter\Processor\CommentCreateProcessor;
use App\Routes\Presentation\InputAdapter\Processor\CommentDeleteProcessor;
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
            name: 'comment_route_list',
            uriTemplate: '/routes/{slug}/comments',
            provider: CommentsByRouteProvider::class,
            normalizationContext: [
                'groups' => [
                    CommentConfig::OUTPUT_LIST,
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
        new Get(
            name: 'comment_profile_list',
            uriTemplate: '/profile/{username}/comments',
            provider: CommentsByUserProvider::class,
            normalizationContext: [
                'groups' => [
                    CommentConfig::OUTPUT_PROFILE_LIST,
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
        new Post(
            name: 'comment_create',
            uriTemplate: '/routes/{slug}/comments',
            read: false,
            processor: CommentCreateProcessor::class,
            normalizationContext: [
                'groups' => [
                    CommentConfig::OUTPUT,
                ],
            ],
            denormalizationContext: [
                'groups' => [
                    CommentConfig::INPUT,
                ],
            ],
            validationContext: [
                'groups' => [
                    CommentConfig::VALID,
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
            name: 'comment_delete',
            uriTemplate: '/comments/{id}',
            processor: CommentDeleteProcessor::class,
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
    ],
)]
final class CommentResource
{
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
        CommentConfig::OUTPUT_LIST,
        CommentConfig::OUTPUT_PROFILE_LIST,
    ])]
    public array $comments = [];

    #[Groups([
        CommentConfig::OUTPUT_LIST,
    ])]
    public float $averageRatings = 0;

    #[Assert\Valid]
    #[Groups([
        CommentConfig::INPUT,
        CommentConfig::OUTPUT
    ])]
    public ?CommentDto $comment = null;
}
