<?php

declare(strict_types=1);

namespace App\Sessions\Presentation\InputAdapter\Processor;

use App\Sessions\Application\UseCase\Command\CreateCheckin\CreateCheckinCommand;
use App\Sessions\Presentation\InputAdapter\Resource\SessionResource;
use App\Shared\Application\InputPort\ApplicationService;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;

/**
 * @implements ProcessorInterface<SessionResource, SessionResource>
 */
final class CheckinCreateProcessor implements ProcessorInterface
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
        $idSession = (int) $uriVariables['id'];

        $command = new CreateCheckinCommand(
            $idSession,
            (int) ($data->checkin?->energy ?? 0),
            (int) ($data->checkin?->stress ?? 0),
            (int) ($data->checkin?->mood ?? 0),
            $data->checkin?->notes,
        );

        $result = new SessionResource();
        $result->checkin = $this->service->handle($command);

        return $result;
    }
}
