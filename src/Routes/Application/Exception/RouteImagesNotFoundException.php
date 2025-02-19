<?php

declare(strict_types=1);

namespace App\Routes\Application\Exception;

use App\Shared\Domain\Exception\AbstractException;

class RouteImagesNotFoundException extends AbstractException
{
    public function __construct(int $id)
    {
        parent::__construct('Images of route id:"' . $id . '" does not exist', 404);
    }
}