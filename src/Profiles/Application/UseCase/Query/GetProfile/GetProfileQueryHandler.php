<?php

declare(strict_types=1);

namespace App\Profiles\Application\UseCase\Query\GetProfile;

use App\Profiles\Application\UseCase\Query\GetProfile\GetProfileQuery;
use App\Profiles\Application\Service\ProfileService;
use App\Profiles\Application\Dto\ProfileDto;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class GetProfileQueryHandler
{
    public function __construct(
        private readonly ProfileService $profileService
    ) {
    }

    /**
     * Selecciona un perfil
     *
     * @param GetProfileQuery $query
     * @return ProfileDto|null
     */
    public function __invoke(GetProfileQuery $query): ?ProfileDto
    {
        $profile = $this->profileService->findProfileSafe($query->username);
        if ($profile !== null) {
            $result = $this->profileService->toDto($profile);
        }
        return $result;
    }
}
