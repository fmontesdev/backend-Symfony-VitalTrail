<?php

declare(strict_types=1);

namespace App\Routes\Application\Exception;

use App\Shared\Domain\Exception\AbstractException;

class CategoryRouteNotFoundException extends AbstractException
{
    public function __construct(string $title)
    {
        parent::__construct('Category Route with title:"' . $title . '" does not exist', 404);
    }
}