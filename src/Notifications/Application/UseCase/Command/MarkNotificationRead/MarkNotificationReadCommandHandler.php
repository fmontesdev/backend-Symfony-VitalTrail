<?php

declare(strict_types=1);

namespace App\Notifications\Application\UseCase\Command\MarkNotificationRead;

use App\Notifications\Domain\OutputPort\NotificationsUsersRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class MarkNotificationReadCommandHandler
{
    public function __construct(
        private readonly NotificationsUsersRepository $notificationsUsersRepository,
    ) {
    }

    public function __invoke(MarkNotificationReadCommand $command): void
    {
        $nu = $this->notificationsUsersRepository->findByNotificationAndUser(
            $command->notificationId,
            $command->userId
        );

        if ($nu === null) {
            throw new \RuntimeException('Notification not found', 404);
        }

        $nu->setIsRead(true);
        $nu->setReadAt(new \DateTime());

        $this->notificationsUsersRepository->save($nu);
    }
}
