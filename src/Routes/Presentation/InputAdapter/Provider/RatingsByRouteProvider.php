<?php

declare(strict_types=1);

namespace App\Routes\Presentation\InputAdapter\Provider;

use App\Routes\Presentation\InputAdapter\Resource\RatingResource;
use App\Routes\Application\UseCase\Query\RatingsByRoute\RatingsByRouteQuery;
use App\Routes\Application\UseCase\Query\AverageRatings\AverageRatingsQuery;
use App\Shared\Application\InputPort\ApplicationService;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;

/**
 * @implements ProviderInterface<RatingResource>
 */
class RatingsByRouteProvider implements ProviderInterface
{
    public function __construct(
        private readonly ApplicationService $service,
    ) {
    }

    /**
     * @param Operation $operation
     * @param string[] $uriVariables
     * @param string[][] $context
     * @return RatingResource
     */
    public function provide(Operation $operation, array $uriVariables = [], array $context = []): ?RatingResource
    {
        $result = new RatingResource();
        $queryCount = new AverageRatingsQuery($uriVariables['slug']);
        $result->averageRatings = $this->service->handle($queryCount);

        $queryRatings = new RatingsByRouteQuery($uriVariables['slug']);
        $ratings = $this->service->handle($queryRatings);
        if ($ratings) {
            $result->ratings = $ratings;
            return $result;
        }
        return null;
    }
}
