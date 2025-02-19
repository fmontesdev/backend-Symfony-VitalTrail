<?php

declare(strict_types=1);

namespace App\Routes\Presentation\InputAdapter\Processor;

use App\Routes\Presentation\InputAdapter\Resource\RouteResource;
use App\Routes\Application\UseCase\Command\Favorite\FavoriteCommand;
use App\Shared\Application\InputPort\ApplicationService;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;

/**
 * @implements ProcessorInterface<RouteResource, RouteResource>
 */
class FavoriteProcessor implements ProcessorInterface
{
    public function __construct(
        private readonly ApplicationService $service,
    ) {
    }

    /**
     * @param RouteResource $data
     * @param Operation $operation
     * @param string[] $uriVariables
     * @param string[][] $context
     * @return RouteResource
     */
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): RouteResource
    {
        $result = new RouteResource();
        // Captura el método HTTP utilizado
        $httpMethod = $operation->getMethod();
        if (isset($uriVariables['slug'])) {
            $command = new FavoriteCommand($uriVariables['slug'], $httpMethod);
            $result->route = $this->service->handle($command);
        }
        return $result;
    }
}
