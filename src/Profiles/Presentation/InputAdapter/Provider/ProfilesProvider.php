<?php

declare(strict_types=1);

namespace App\Profiles\Presentation\InputAdapter\Provider;

use App\Profiles\Presentation\InputAdapter\Resource\ProfileResource;
use App\Profiles\Application\UseCase\Query\GetProfiles\GetProfilesQuery;
use App\Profiles\Application\UseCase\Query\CountProfiles\CountProfilesQuery;
use App\Shared\Application\InputPort\ApplicationService;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;

/**
 * @implements ProviderInterface<ProfileResource>
 */
class ProfilesProvider implements ProviderInterface
{
    public function __construct(
        private readonly ApplicationService $service,
    ) {
    }

    /**
     * @param Operation $operation
     * @param string[] $uriVariables
     * @param string[][] $context
     * @return ProfileResource
     */
    public function provide(Operation $operation, array $uriVariables = [], array $context = []): ProfileResource
    {
        $result = new ProfileResource();
        $queryCount = new CountProfilesQuery($uriVariables['username'], $uriVariables['follows']);
        $result->profilesCount = $this->service->handle($queryCount);

        if ($result->profilesCount) {
            $queryProfiles = new GetProfilesQuery($uriVariables['username'], $uriVariables['follows']);
            $result->profiles = $this->service->handle($queryProfiles);
        }

        return $result;
    }
}
