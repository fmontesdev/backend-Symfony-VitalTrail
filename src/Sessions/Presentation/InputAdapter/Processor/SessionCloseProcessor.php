<?php

declare(strict_types=1);

namespace App\Sessions\Presentation\InputAdapter\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Sessions\Application\UseCase\Command\CloseSession\CloseSessionCommand;
use App\Sessions\Presentation\InputAdapter\Resource\SessionResource;
use App\Shared\Application\InputPort\ApplicationService;
use DateTimeImmutable;

/**
 * @implements ProcessorInterface<SessionResource, SessionResource>
 */
final class SessionCloseProcessor implements ProcessorInterface
{
    public function __construct(
        private readonly ApplicationService $service,
    ) {
    }

    /**
     * @param SessionResource $data
     */
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): SessionResource
    {
        $idSession = (int) $uriVariables['id'];
        $endAt = DateTimeImmutable::createFromInterface($data->session->endAt);

        $command = new CloseSessionCommand($idSession, $endAt);

        $result = new SessionResource();
        $result->session = $this->service->handle($command);
        $result->id = $result->session->idSession;

        return $result;
    }
}
