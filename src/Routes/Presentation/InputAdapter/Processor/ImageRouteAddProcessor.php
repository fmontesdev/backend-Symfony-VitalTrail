<?php

declare(strict_types=1);

namespace App\Routes\Presentation\InputAdapter\Processor;

use App\Routes\Presentation\InputAdapter\Resource\ImageRouteResource;
use App\Routes\Application\UseCase\Command\AddImageRoute\AddImageToRouteCommand;
use App\Shared\Application\InputPort\ApplicationService;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;

/**
 * @implements ProcessorInterface<ImageRouteResource, ImageRouteResource>
 */
class ImageRouteAddProcessor implements ProcessorInterface
{
    public function __construct(
        private readonly ApplicationService $service,
    ) {
    }

    /**
     * @param ImageRouteResource $data
     * @param Operation $operation
     * @param string[] $uriVariables
     * @param string[][] $context
     * @return ImageRouteResource
     */
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): ImageRouteResource
    {
        $result = new ImageRouteResource();
        if ($data->image !== null) {
            $command = new AddImageToRouteCommand($data->image, (int) $uriVariables['idRoute']);
            $result->images = $this->service->handle($command);
        }
        return $result;
    }
}
