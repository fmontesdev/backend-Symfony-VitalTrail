<?php

declare(strict_types=1);

namespace App\Routes\Presentation\InputAdapter\Processor;

use App\Routes\Presentation\InputAdapter\Resource\ImageRouteResource;
use App\Routes\Application\UseCase\Command\DeleteImageRoute\DeleteImageRouteCommand;
use App\Shared\Application\InputPort\ApplicationService;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;

/**
 * @implements ProcessorInterface<ImageRouteResource, ImageRouteResource>
 */
class ImageRouteDeleteProcessor implements ProcessorInterface
{
    public function __construct(
        private readonly ApplicationService $service,
    ) {
    }

    /**
     * @param ImageRouteResource $data
     * @param Operation $operation
     * @param int[] $uriVariables
     * @param string[][] $context
     * @return ImageRouteResource
     */
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): void
    {
        $command = new DeleteImageRouteCommand((int) $uriVariables['idImg']);
        $this->service->handle($command);
    }
}
