<?php

declare(strict_types=1);

namespace App\Notifications\Application\UseCase\Query\GetMyNotifications;

use App\Notifications\Application\Dto\NotificationDto;
use App\Notifications\Application\Dto\NotificationsPageDto;
use App\Notifications\Domain\OutputPort\NotificationsUsersRepository;
use App\Notifications\Presentation\InputAdapter\Mapper\NotificationMapper;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class GetMyNotificationsQueryHandler
{
    public function __construct(
        private readonly NotificationsUsersRepository $notificationsUsersRepository,
    ) {
    }

    public function __invoke(GetMyNotificationsQuery $query): NotificationsPageDto
    {
        $notificationsUsers = $this->notificationsUsersRepository->findByUser($query->userId);
        $unreadCount = $this->notificationsUsersRepository->countUnreadByUser($query->userId);

        $dtos = array_map(
            static fn ($nu) => NotificationMapper::mapToDto($nu),
            $notificationsUsers
        );

        return new NotificationsPageDto($dtos, $unreadCount);
    }
}
