<?php

declare(strict_types=1);

namespace App\Routes\Application\UseCase\Query\CountRoutes;

use App\Routes\Application\UseCase\Query\CountRoutes\CountRoutesQuery;
use App\Routes\Domain\OutputPort\RouteRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class CountRoutesQueryHandler
{
    public function __construct(
        private readonly RouteRepository $repository,
    ) {
    }

    /**
     * Cuenta el total de rutas
     *
     * @param CountRoutesQuery $query
     * @return int
     */
    public function __invoke(CountRoutesQuery $query): int
    {
        return $this->repository->countRoutes( 
            $query->category,
            $query->location,
            $query->title,
            $query->distance,
            $query->difficulty,
            $query->typeRoute,
            $query->author
        );
    }
}
