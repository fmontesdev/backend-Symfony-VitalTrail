<?php

declare(strict_types=1);

namespace App\Notifications\Presentation\InputAdapter\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Auth\Domain\Entity\User;
use App\Notifications\Application\UseCase\Command\MarkNotificationRead\MarkNotificationReadCommand;
use App\Notifications\Presentation\InputAdapter\Resource\NotificationResource;
use App\Shared\Application\InputPort\ApplicationService;
use Symfony\Bundle\SecurityBundle\Security;

/**
 * @implements ProcessorInterface<NotificationResource, null>
 */
final class MarkReadProcessor implements ProcessorInterface
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
        /** @var User $user */
        $user = $this->security->getUser();
        $userId = (string) $user->getIdUser();
        $notificationId = (int) $uriVariables['id'];

        $this->service->handle(new MarkNotificationReadCommand($notificationId, $userId));

        return null;
    }
}
