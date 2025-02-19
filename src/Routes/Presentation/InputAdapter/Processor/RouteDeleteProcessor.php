<?php

declare(strict_types=1);

namespace App\Routes\Presentation\InputAdapter\Processor;

use App\Routes\Presentation\InputAdapter\Resource\RouteResource;
use App\Routes\Application\UseCase\Command\DeleteRoute\DeleteRouteCommand;
use App\Shared\Application\InputPort\ApplicationService;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;

/**
 * @implements ProcessorInterface<RouteResource, RouteResource>
 */
class RouteDeleteProcessor implements ProcessorInterface
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
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): void
    {
        $command = new DeleteRouteCommand($uriVariables['slug']);
        $this->service->handle($command);
    }
}
