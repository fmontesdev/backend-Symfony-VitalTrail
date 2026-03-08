<?php

declare(strict_types=1);

namespace App\Sessions\Presentation\InputAdapter\Provider;

use App\Sessions\Application\UseCase\Query\GetSession\GetSessionQuery;
use App\Sessions\Presentation\InputAdapter\Resource\SessionResource;
use App\Shared\Application\InputPort\ApplicationService;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;

/**
 * @implements ProviderInterface<SessionResource>
 */
final class SessionProvider implements ProviderInterface
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
        $result->session = $this->service->handle(new GetSessionQuery((int) $uriVariables['id']));

        return $result;
    }
}
