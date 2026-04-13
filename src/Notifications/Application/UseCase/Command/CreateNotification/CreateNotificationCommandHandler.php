<?php

declare(strict_types=1);

namespace App\Notifications\Application\UseCase\Command\CreateNotification;

use App\Auth\Domain\OutputPort\UserRepository;
use App\Notifications\Domain\Entity\Notification;
use App\Notifications\Domain\Entity\NotificationsUsers;
use App\Notifications\Domain\OutputPort\NotificationRepository;
use App\Notifications\Domain\OutputPort\NotificationsUsersRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class CreateNotificationCommandHandler
{
    public function __construct(
        private readonly NotificationRepository $notificationRepository,
        private readonly NotificationsUsersRepository $notificationsUsersRepository,
        private readonly UserRepository $userRepository,
    ) {
    }

    public function __invoke(CreateNotificationCommand $command): void
    {
        $notification = new Notification(
            $command->title,
            $command->description,
            $command->type,
        );

        $this->notificationRepository->save($notification);

        if ($command->targetUserId !== null) {
            $user = $this->userRepository->findById($command->targetUserId);
            if ($user !== null) {
                $this->notificationsUsersRepository->save(new NotificationsUsers($notification, $user));
            }

            return;
        }

        if ($command->targetRole !== null) {
            $users = $this->userRepository->findByRole($command->targetRole);
        } else {
            $users = $this->userRepository->findAllActive();
        }

        foreach ($users as $user) {
            $this->notificationsUsersRepository->save(new NotificationsUsers($notification, $user));
        }
    }
}
