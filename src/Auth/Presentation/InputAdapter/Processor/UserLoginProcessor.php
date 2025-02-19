<?php

declare(strict_types=1);

namespace App\Auth\Presentation\InputAdapter\Processor;

use App\Auth\Presentation\InputAdapter\Resource\UserResource;
use App\Auth\Application\InputPort\UserService;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;



/**
 * @implements ProcessorInterface<UserResource, UserResource>
 */
class UserLoginProcessor implements ProcessorInterface
{
    public function __construct(
        private UserService $userService,
    ) {
    }

    /**
     * @param UserResource $data
     * @param Operation $operation
     * @param string[] $uriVariables
     * @param string[][] $context
     * @return UserResource
     */
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): UserResource   
    {
        $result = new UserResource();
        if ($data->user !== null) {
            $result->user = $this->userService->loginUser($data->user);
        }
        return $result;
    }
}
