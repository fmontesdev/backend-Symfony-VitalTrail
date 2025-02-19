<?php

declare(strict_types=1);

namespace App\Routes\Presentation\InputAdapter\Processor;

use App\Routes\Presentation\InputAdapter\Resource\RatingResource;
use App\Routes\Application\UseCase\Command\DeleteRating\DeleteRatingCommand;
use App\Shared\Application\InputPort\ApplicationService;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;

/**
 * @implements ProcessorInterface<RatingResource, RatingResource>
 */
class RatingDeleteProcessor implements ProcessorInterface
{
    public function __construct(
        private readonly ApplicationService $service,
    ) {
    }

    /**
     * @param RatingResource $data
     * @param Operation $operation
     * @param mixed[] $uriVariables
     * @param string[][] $context
     * @return RatingResource
     */
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): void
    {
        $command = new DeleteRatingCommand($uriVariables['slug'], (int) $uriVariables['id']);
        $this->service->handle($command);
    }
}
