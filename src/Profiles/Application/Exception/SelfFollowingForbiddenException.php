<?php

declare(strict_types=1);

namespace App\Profiles\Application\Exception;

use App\Shared\Domain\Exception\AbstractException;

class SelfFollowingForbiddenException extends AbstractException
{
    public function __construct()
    {
        parent::__construct('Self following/unfollowing is not allowed', 403);
    }
}