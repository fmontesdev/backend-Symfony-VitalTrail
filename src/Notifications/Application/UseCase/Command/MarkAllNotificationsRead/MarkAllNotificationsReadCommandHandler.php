<?php

declare(strict_types=1);

namespace App\Notifications\Application\UseCase\Command\MarkAllNotificationsRead;

use App\Notifications\Domain\OutputPort\NotificationsUsersRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class MarkAllNotificationsReadCommandHandler
{
    public function __construct(
        private readonly NotificationsUsersRepository $notificationsUsersRepository,
    ) {
    }

    public function __invoke(MarkAllNotificationsReadCommand $command): void
    {
        $unread = $this->notificationsUsersRepository->findAllUnreadByUser($command->userId);
        $now = new \DateTime();

        foreach ($unread as $nu) {
            $nu->setIsRead(true);
            $nu->setReadAt($now);
            $this->notificationsUsersRepository->save($nu);
        }
    }
}
