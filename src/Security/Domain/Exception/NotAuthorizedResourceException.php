<?php

declare(strict_types=1);

namespace App\Security\Domain\Exception;

use App\Shared\Domain\Exception\AbstractException;

class  NotAuthorizedResourceException extends AbstractException
{
    public function __construct()
    {
        parent::__construct('Resource to view/update/delete is not authorized', 403);
    }
}