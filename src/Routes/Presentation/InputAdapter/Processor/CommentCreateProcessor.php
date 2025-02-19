<?php

declare(strict_types=1);

namespace App\Routes\Presentation\InputAdapter\Processor;

use App\Routes\Presentation\InputAdapter\Resource\CommentResource;
use App\Routes\Application\UseCase\Command\CreateComment\CreateCommentCommand;
use App\Shared\Application\InputPort\ApplicationService;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;

/**
 * @implements ProcessorInterface<CommentResource, CommentResource>
 */
class CommentCreateProcessor implements ProcessorInterface
{
    public function __construct(
        private readonly ApplicationService $service,
    ) {
    }

    /**
     * @param CommentResource $data
     * @param Operation $operation
     * @param string[] $uriVariables
     * @param string[][] $context
     * @return CommentResource
     */
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): CommentResource
    {
        $result = new CommentResource();
        if ($data->comment !== null) {
            $command = new CreateCommentCommand($data->comment, $uriVariables['slug']);
            $result->comment = $this->service->handle($command);
        }
        return $result;
    }
}
