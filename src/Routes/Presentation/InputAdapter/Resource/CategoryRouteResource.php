<?php

declare(strict_types=1);

namespace App\Routes\Presentation\InputAdapter\Resource;

use App\Routes\Application\Config\CategoryRouteConfig;
use App\Routes\Application\Dto\CategoryRouteDto;
use App\Routes\Presentation\InputAdapter\Provider\CategoryRoutesProvider;
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
            name: 'category_route_list',
            uriTemplate: '/routes/categories',
            provider: CategoryRoutesProvider::class,
            normalizationContext: [
                'groups' => [
                    CategoryRouteConfig::OUTPUT_LIST,
                ],
            ],
            openapi: new Operation(
                summary: '',
                description: '',
            ),
        ),
    ],
)]
final class CategoryRouteResource
{
    /**
     * @var CategoryRouteDto[]
     */
    #[ApiProperty(
        builtinTypes: [
            new Type(
                builtinType: Type::BUILTIN_TYPE_ARRAY,
                collection: true,
                collectionValueType: [
                    new Type(
                        builtinType: Type::BUILTIN_TYPE_OBJECT,
                        class: CategoryRouteDto::class,
                    ),
                ],
            ),
        ],
    )]
    #[Groups([
        CategoryRouteConfig::OUTPUT_LIST,
    ])]
    public array $categories = [];

    #[Assert\Valid]
    #[Groups([
        CategoryRouteConfig::OUTPUT
    ])]
    public ?CategoryRouteDto $category = null;
}
