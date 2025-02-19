<?php

declare(strict_types=1);

namespace App\Routes\Presentation\InputAdapter\Processor;

use App\Routes\Presentation\InputAdapter\Resource\RouteResource;
use App\Routes\Application\UseCase\Command\UpdateRoute\UpdateRouteCommand;
use App\Shared\Application\InputPort\ApplicationService;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;

/**
 * @implements ProcessorInterface<RouteResource, RouteResource>
 */
class RouteUpdateProcessor implements ProcessorInterface
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
        if ($data->route !== null) {
            $command = new UpdateRouteCommand($uriVariables['slug'], $data->route);
            $result->route = $this->service->handle($command);
        }
        return $result;
    }
}
