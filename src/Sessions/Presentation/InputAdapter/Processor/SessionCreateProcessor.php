<?php

declare(strict_types=1);

namespace App\Sessions\Presentation\InputAdapter\Processor;

use App\Sessions\Application\UseCase\Command\CreateSession\CreateSessionCommand;
use App\Sessions\Presentation\InputAdapter\Resource\SessionResource;
use App\Shared\Application\InputPort\ApplicationService;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use DateTimeImmutable;

/**
 * @implements ProcessorInterface<SessionResource, SessionResource>
 */
final class SessionCreateProcessor implements ProcessorInterface
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
     * @return SessionResource
     */
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): SessionResource
    {
        $idRoute = (int) ($data->session?->idRoute ?? 0);
        $startAt = $data->session?->startAt !== null
            ? DateTimeImmutable::createFromInterface($data->session->startAt)
            : null;

        $command = new CreateSessionCommand($idRoute, $startAt);

        $result = new SessionResource();
        $result->session = $this->service->handle($command);

        return $result;
    }
}
