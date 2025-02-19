<?php

declare(strict_types=1);

namespace App\Routes\Presentation\InputAdapter\Provider;

use App\Routes\Presentation\InputAdapter\Resource\CommentResource;
use App\Routes\Application\UseCase\Query\CommentsByUser\CommentsByUserQuery;
use App\Routes\Application\UseCase\Query\AverageRatings\AverageRatingsQuery;
use App\Shared\Application\InputPort\ApplicationService;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;

/**
 * @implements ProviderInterface<CommentResource>
 */
class CommentsByUserProvider implements ProviderInterface
{
    public function __construct(
        private readonly ApplicationService $service,
    ) {
    }

    /**
     * @param Operation $operation
     * @param string[] $uriVariables
     * @param string[][] $context
     * @return CommentResource
     */
    public function provide(Operation $operation, array $uriVariables = [], array $context = []): ?CommentResource
    {
        $result = new CommentResource();
        $query = new CommentsByUserQuery($uriVariables['username']);
        $comments = $this->service->handle($query);
        if ($comments) {
            $result->comments = $comments;
            return $result;
        }
        return null;
    }
}
