<?php

declare(strict_types=1);

namespace App\Sessions\Presentation\InputAdapter\Processor;

use App\Sessions\Application\UseCase\Command\DeleteSession\DeleteSessionCommand;
use App\Sessions\Presentation\InputAdapter\Resource\SessionResource;
use App\Shared\Application\InputPort\ApplicationService;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;

/**
 * @implements ProcessorInterface<SessionResource, void>
 */
final class SessionDeleteProcessor implements ProcessorInterface
{
    public function __construct(
        private readonly ApplicationService $service,
    ) {
    }

    /**
     * @param SessionResource $data
     * @param Operation $operation
     * @param mixed[] $uriVariables
     * @param string[][] $context
     */
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): void
    {
        $this->service->handle(new DeleteSessionCommand((int) $uriVariables['id']));
    }
}
