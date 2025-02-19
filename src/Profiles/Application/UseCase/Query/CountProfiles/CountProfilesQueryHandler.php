<?php

declare(strict_types=1);

namespace App\Profiles\Application\UseCase\Query\CountProfiles;

use App\Profiles\Application\UseCase\Query\CountProfiles\CountProfilesQuery;
use App\Profiles\Domain\OutputPort\ProfileRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class CountProfilesQueryHandler
{
    public function __construct(
        private readonly ProfileRepository $profileRepository,
    ) {
    }

    /**
     * Cuenta el total de profiles que siguen/sigue un usuario
     *
     * @param CountProfilesQuery $query
     * @return int
     */
    public function __invoke(CountProfilesQuery $query): int
    {
        if ($query->follows === 'followers') {
            $countProfiles = $this->profileRepository->countFollowerProfiles($query->username);
        }
        if ($query->follows === 'followings') {
            $countProfiles = $this->profileRepository->countFollowingProfiles($query->username);
        }

        if(!isset($countProfiles)) return 0;
        return $countProfiles;
    }
}
