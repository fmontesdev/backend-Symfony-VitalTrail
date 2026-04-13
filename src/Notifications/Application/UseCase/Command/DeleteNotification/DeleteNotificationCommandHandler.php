<?php

declare(strict_types=1);

namespace App\Notifications\Application\UseCase\Command\DeleteNotification;

use App\Notifications\Domain\OutputPort\NotificationRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class DeleteNotificationCommandHandler
{
    public function __construct(
        private readonly NotificationRepository $notificationRepository,
    ) {
    }

    public function __invoke(DeleteNotificationCommand $command): void
    {
        $notification = $this->notificationRepository->findById($command->notificationId);

        if ($notification === null) {
            throw new \RuntimeException('Notification not found', 404);
        }

        $this->notificationRepository->delete($notification);
    }
}
