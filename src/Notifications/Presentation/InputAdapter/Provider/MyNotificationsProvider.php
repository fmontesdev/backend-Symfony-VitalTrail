<?php

declare(strict_types=1);

namespace App\Notifications\Presentation\InputAdapter\Provider;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Auth\Domain\Entity\User;
use App\Notifications\Application\UseCase\Query\GetMyNotifications\GetMyNotificationsQuery;
use App\Notifications\Presentation\InputAdapter\Mapper\NotificationMapper;
use App\Notifications\Presentation\InputAdapter\Resource\NotificationListResource;
use App\Shared\Application\InputPort\ApplicationService;
use Symfony\Bundle\SecurityBundle\Security;

/**
 * @implements ProviderInterface<NotificationListResource>
 */
final class MyNotificationsProvider implements ProviderInterface
{
    public function __construct(
        private readonly ApplicationService $service,
        private readonly Security $security,
    ) {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): NotificationListResource
    {
        /** @var User $user */
        $user = $this->security->getUser();
        $userId = (string) $user->getIdUser();

        /** @var \App\Notifications\Application\Dto\NotificationsPageDto $pageDto */
        $pageDto = $this->service->handle(new GetMyNotificationsQuery($userId));

        return NotificationMapper::mapPageToResource($pageDto);
    }
}
