<?php

declare(strict_types=1);

namespace App\Notifications\Application\UseCase\Query\GetMyNotifications;

use App\Shared\Application\Query\BaseQuery;

final class GetMyNotificationsQuery implements BaseQuery
{
    public function __construct(
        public readonly string $userId,
    ) {
    }
}
