<?php

declare(strict_types=1);

namespace App\Sessions\Presentation\InputAdapter\Provider;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Sessions\Application\UseCase\Query\GetCheckin\GetCheckinQuery;
use App\Sessions\Presentation\InputAdapter\Resource\SessionResource;
use App\Shared\Application\InputPort\ApplicationService;

/**
 * @implements ProviderInterface<SessionResource>
 */
final class CheckinProvider implements ProviderInterface
{
    public function __construct(
        private readonly ApplicationService $service,
    ) {
    }

    /**
     * @param Operation $operation
     * @param mixed[] $uriVariables
     * @param string[][] $context
     * @return SessionResource
     */
    public function provide(Operation $operation, array $uriVariables = [], array $context = []): SessionResource
    {
        $result = new SessionResource();
        $result->checkin = $this->service->handle(new GetCheckinQuery((int) $uriVariables['id']));

        return $result;
    }
}
