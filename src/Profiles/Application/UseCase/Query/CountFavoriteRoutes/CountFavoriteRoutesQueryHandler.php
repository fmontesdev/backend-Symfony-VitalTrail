<?php

declare(strict_types=1);

namespace App\Profiles\Application\UseCase\Query\CountFavoriteRoutes;

use App\Auth\Domain\OutputPort\UserRepository;
use App\Profiles\Application\Exception\ProfileNotFoundException;
use App\Routes\Domain\OutputPort\FavoriteRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class CountFavoriteRoutesQueryHandler
{
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly FavoriteRepository $favoriteRepository,
    ) {
    }

    public function __invoke(CountFavoriteRoutesQuery $query): int
    {
        $user = $this->userRepository->findByUsername($query->username);

        if ($user === null) {
            throw new ProfileNotFoundException($query->username);
        }

        return $this->favoriteRepository->countByUser($user);
    }
}
