<?php

declare(strict_types=1);

namespace App\Profiles\Presentation\InputAdapter\Processor;

use App\Profiles\Presentation\InputAdapter\Resource\ProfileResource;
use App\Profiles\Application\UseCase\Command\Follow\FollowCommand;
use App\Shared\Application\InputPort\ApplicationService;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;

/**
 * @implements ProcessorInterface<ProfileResource, ProfileResource>
 */
class FollowProcessor implements ProcessorInterface
{
    public function __construct(
        private readonly ApplicationService $service,
    ) {
    }

    /**
     * @param ProfileResource $data
     * @param Operation $operation
     * @param string[] $uriVariables
     * @param string[][] $context
     * @return ProfileResource
     */
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): ProfileResource
    {
        $result = new ProfileResource();
        // Captura el método HTTP utilizado
        $httpMethod = $operation->getMethod();
        if (isset($uriVariables['username'])) {
            $command = new FollowCommand($uriVariables['username'], $httpMethod);
            $result->profile = $this->service->handle($command);
        }
        return $result;
    }
}
