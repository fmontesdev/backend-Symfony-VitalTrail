<?php

declare(strict_types=1);

namespace App\Admin\Presentation\InputAdapter\Processor;

use App\Admin\Application\UseCase\Command\DeleteAdminUser\DeleteAdminUserCommand;
use App\Admin\Presentation\InputAdapter\Resource\AdminUserResource;
use App\Shared\Application\InputPort\ApplicationService;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;

/**
 * @implements ProcessorInterface<AdminUserResource, void>
 */
final class AdminUserDeleteProcessor implements ProcessorInterface
{
    public function __construct(
        private readonly ApplicationService $service,
    ) {
    }

    /**
     * @param AdminUserResource $data
     * @param Operation $operation
     * @param mixed[] $uriVariables
     * @param string[][] $context
     */
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): void
    {
        $this->service->handle(new DeleteAdminUserCommand((string) $uriVariables['idUser']));
    }
}
