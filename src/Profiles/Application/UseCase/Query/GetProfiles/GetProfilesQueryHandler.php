<?php

declare(strict_types=1);

namespace App\Profiles\Application\UseCase\Query\GetProfiles;

use App\Profiles\Application\UseCase\Query\GetProfiles\GetProfilesQuery;
use App\Auth\Domain\Entity\User;
use App\Profiles\Application\Dto\ProfileDto;
use App\Profiles\Application\Service\ProfileService;
use App\Profiles\Domain\OutputPort\ProfileRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class GetProfilesQueryHandler
{
    public function __construct(
        private readonly ProfileRepository $profileRepository,
        private readonly ProfileService $profileService,
    ) {
    }

    /**
     * Lista profiles que siguen/sigue un usuario
     *
     * @param GetProfilesQuery $query
     * @return ProfileDto[]
     */
    public function __invoke(GetProfilesQuery $query): array
    {
        if ($query->follows === 'followers') {
            $profiles = $this->profileRepository->findAllFollowerProfiles($query->username);
        }
        if ($query->follows === 'followings') {
            $profiles = $this->profileRepository->findAllFollowingProfiles($query->username);
        }

        if (!isset($profiles)) return [];
        return array_map(fn (User $profile) => $this->profileService->toDto($profile), $profiles);
    }
}
