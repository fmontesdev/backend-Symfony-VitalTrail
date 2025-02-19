<?php

declare(strict_types=1);

namespace App\Auth\Presentation\InputAdapter\Provider;

use App\Auth\Presentation\InputAdapter\Resource\UserResource;
use App\Auth\Application\InputPort\UserService;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;

/**
 * @implements ProviderInterface<UserResource>
 */
class UserCurrentProvider implements ProviderInterface
{
    public function __construct(
        private UserService $userService,
    ) {
    }

    /**
     * @param Operation $operation
     * @param string[] $uriVariables
     * @param string[][] $context
     * @return UserResource
     */
    public function provide(Operation $operation, array $uriVariables = [], array $context = []): UserResource
    {
        $result = new UserResource();
        $result->user = $this->userService->getCurrentUser();
        return $result;
    }
}
