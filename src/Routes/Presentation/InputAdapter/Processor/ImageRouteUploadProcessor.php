<?php

declare(strict_types=1);

namespace App\Routes\Presentation\InputAdapter\Processor;

use App\Routes\Application\Dto\ImageRouteDto;
use App\Routes\Application\UseCase\Command\AddImageRoute\AddImageToRouteCommand;
use App\Routes\Presentation\InputAdapter\Resource\ImageRouteResource;
use App\Shared\Application\InputPort\ApplicationService;
use App\Shared\Application\Service\FileUploadService;
use App\Shared\Application\Exception\InvalidImageFileException;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * @implements ProcessorInterface<ImageRouteResource, ImageRouteResource>
 */
final class ImageRouteUploadProcessor implements ProcessorInterface
{
    public function __construct(
        private readonly ApplicationService $service,
        private readonly FileUploadService $fileUploadService,
        private readonly RequestStack $requestStack,
    ) {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): ImageRouteResource
    {
        $request = $this->requestStack->getCurrentRequest();
        $file = $request->files->get('file');

        if ($file === null) {
            throw new InvalidImageFileException('File field is required');
        }

        $filename = $this->fileUploadService->upload($file, 'routes', (string) $uriVariables['idRoute']);

        $dto = new ImageRouteDto();
        $dto->imgRoute = $filename;

        $command = new AddImageToRouteCommand($dto, (int) $uriVariables['idRoute']);

        $result = new ImageRouteResource();
        $result->images = $this->service->handle($command);

        return $result;
    }
}
