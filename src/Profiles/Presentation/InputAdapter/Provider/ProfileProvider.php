<?php

declare(strict_types=1);

namespace App\Profiles\Presentation\InputAdapter\Provider;

use App\Profiles\Presentation\InputAdapter\Resource\ProfileResource;
use App\Profiles\Application\UseCase\Query\GetProfile\GetProfileQuery;
use App\Shared\Application\InputPort\ApplicationService;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;

/**
 * @implements ProviderInterface<ProfileResource>
 */
class ProfileProvider implements ProviderInterface
{
    public function __construct(
        private readonly ApplicationService $service,
    ) {
    }

    /**
     * @param Operation $operation
     * @param string[] $uriVariables
     * @param string[][] $context
     * @return ProfileResource|null
     */
    public function provide(Operation $operation, array $uriVariables = [], array $context = []): ?ProfileResource
    {
        $query = new GetProfileQuery($uriVariables['username']);
        $profile = $this->service->handle($query);
        if ($profile) {
            $result = new ProfileResource();
            $result->profile = $profile;
            return $result;
        }
        return null;
    }
}
