<?php

declare(strict_types=1);

namespace App\Profiles\Application\UseCase\Query\GetFavoriteRoutes;

use App\Auth\Domain\OutputPort\UserRepository;
use App\Profiles\Application\Exception\ProfileNotFoundException;
use App\Routes\Application\Dto\RouteDto;
use App\Routes\Domain\OutputPort\FavoriteRepository;
use App\Routes\Presentation\Mapper\RouteMapper;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class GetFavoriteRoutesQueryHandler
{
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly FavoriteRepository $favoriteRepository,
        private readonly RouteMapper $routeMapper,
    ) {
    }

    /**
     * @return RouteDto[]
     */
    public function __invoke(GetFavoriteRoutesQuery $query): array
    {
        $user = $this->userRepository->findByUsername($query->username);
        if ($user === null) {
            throw new ProfileNotFoundException($query->username);
        }

        $routes = $this->favoriteRepository->findByUser($user);

        return $this->routeMapper->mapEntitiesToDtoArray($routes, 'getAllRoute');
    }
}
