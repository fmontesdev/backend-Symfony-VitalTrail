<?php

declare(strict_types=1);

namespace App\Sessions\Presentation\InputAdapter\Provider;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Sessions\Application\UseCase\Query\GetCheckinsByUser\GetCheckinsByUserQuery;
use App\Sessions\Presentation\InputAdapter\Resource\SessionResource;
use App\Shared\Application\InputPort\ApplicationService;

/**
 * @implements ProviderInterface<SessionResource>
 */
final class CheckinsProvider implements ProviderInterface
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
        $result->checkins = $this->service->handle(new GetCheckinsByUserQuery());

        return $result;
    }
}
