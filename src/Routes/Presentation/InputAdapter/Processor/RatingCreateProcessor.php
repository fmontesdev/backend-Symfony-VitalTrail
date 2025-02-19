<?php

declare(strict_types=1);

namespace App\Routes\Presentation\InputAdapter\Processor;

use App\Routes\Presentation\InputAdapter\Resource\RatingResource;
use App\Routes\Application\UseCase\Command\CreateRating\CreateRatingCommand;
use App\Routes\Application\UseCase\Query\AverageRatings\AverageRatingsQuery;
use App\Shared\Application\InputPort\ApplicationService;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;

/**
 * @implements ProcessorInterface<RatingResource, RatingResource>
 */
class RatingCreateProcessor implements ProcessorInterface
{
    public function __construct(
        private readonly ApplicationService $service,
    ) {
    }

    /**
     * @param RatingResource $data
     * @param Operation $operation
     * @param string[] $uriVariables
     * @param string[][] $context
     * @return RatingResource
     */
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): RatingResource
    {
        $result = new RatingResource();
        if ($data->rating !== null) {
            $command = new CreateRatingCommand($data->rating, $uriVariables['slug']);
            $result->comments = $this->service->handle($command);
        }

        $query = new AverageRatingsQuery($uriVariables['slug']);
        $result->averageRatings = $this->service->handle($query);

        return $result;
    }
}
