<?php

declare(strict_types=1);

namespace App\Routes\Presentation\InputAdapter\Provider;

use App\Routes\Presentation\InputAdapter\Resource\ImageRouteResource;
use App\Routes\Application\UseCase\Query\ImagesByRoute\ImagesByRouteQuery;
use App\Shared\Application\InputPort\ApplicationService;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;

/**
 * @implements ProviderInterface<ImageRouteResource>
 */
class ImagesByRouteProvider implements ProviderInterface
{
    public function __construct(
        private readonly ApplicationService $service,
    ) {
    }

    /**
     * @param Operation $operation
     * @param string[] $uriVariables
     * @param string[][] $context
     * @return ImageRouteResource
     */
    public function provide(Operation $operation, array $uriVariables = [], array $context = []): ?ImageRouteResource
    {
        $query = new ImagesByRouteQuery((int) $uriVariables['idRoute']);
        $images = $this->service->handle($query);
        if ($images) {
            $result = new ImageRouteResource();
            $result->images = $images;
            return $result;
        }
        return null;
    }
}
