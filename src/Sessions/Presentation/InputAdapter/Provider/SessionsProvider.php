<?php

declare(strict_types=1);

namespace App\Sessions\Presentation\InputAdapter\Provider;

use App\Sessions\Application\UseCase\Query\GetSessionsByUser\GetSessionsByUserQuery;
use App\Sessions\Presentation\InputAdapter\Resource\SessionResource;
use App\Shared\Application\InputPort\ApplicationService;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;

/**
 * @implements ProviderInterface<SessionResource>
 */
final class SessionsProvider implements ProviderInterface
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
        $limit = intval($context['filters']['limit'] ?? 10);
        $offset = intval($context['filters']['offset'] ?? 0);

        $result = new SessionResource();
        $data = $this->service->handle(new GetSessionsByUserQuery($limit, $offset));
        $result->sessions = $data['sessions'];
        $result->sessionsCount = $data['count'];

        return $result;
    }
}
