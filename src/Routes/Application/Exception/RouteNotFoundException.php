<?php

declare(strict_types=1);

namespace App\Routes\Application\Exception;

use App\Shared\Domain\Exception\AbstractException;

class RouteNotFoundException extends AbstractException
{
    public function __construct(?string $slug)
    {
        parent::__construct('Route "' . $slug . '" does not exist', 404);
    }
}