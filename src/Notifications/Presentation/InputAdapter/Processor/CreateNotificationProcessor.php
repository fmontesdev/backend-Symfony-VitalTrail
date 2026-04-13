<?php

declare(strict_types=1);

namespace App\Notifications\Presentation\InputAdapter\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Notifications\Application\UseCase\Command\CreateNotification\CreateNotificationCommand;
use App\Notifications\Presentation\InputAdapter\Resource\NotificationResource;
use App\Shared\Application\InputPort\ApplicationService;
use Symfony\Bundle\SecurityBundle\Security;

/**
 * @implements ProcessorInterface<NotificationResource, null>
 */
final class CreateNotificationProcessor implements ProcessorInterface
{
    public function __construct(
        private readonly ApplicationService $service,
        private readonly Security $security,
    ) {
    }

    /**
     * @param NotificationResource $data
     * @param mixed[] $uriVariables
     * @param string[][] $context
     */
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): null
    {
        $this->service->handle(new CreateNotificationCommand(
            title: (string) $data->title,
            description: (string) $data->description,
            type: (string) $data->type,
            targetUserId: $data->targetUserId,
            targetRole: $data->targetRole,
        ));

        return null;
    }
}
