<?php

declare(strict_types=1);

namespace App\Routes\Presentation\InputAdapter\Processor;

use App\Routes\Presentation\InputAdapter\Resource\CommentResource;
use App\Routes\Application\UseCase\Command\DeleteComment\DeleteCommentCommand;
use App\Shared\Application\InputPort\ApplicationService;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;

/**
 * @implements ProcessorInterface<CommentResource, CommentResource>
 */
class CommentDeleteProcessor implements ProcessorInterface
{
    public function __construct(
        private readonly ApplicationService $service,
    ) {
    }

    /**
     * @param CommentResource $data
     * @param Operation $operation
     * @param mixed[] $uriVariables
     * @param string[][] $context
     * @return CommentResource
     */
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): void
    {
        $command = new DeleteCommentCommand( (int) $uriVariables['id']);
        $this->service->handle($command);
    }
}
