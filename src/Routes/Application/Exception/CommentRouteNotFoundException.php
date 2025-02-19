<?php

declare(strict_types=1);

namespace App\Routes\Application\Exception;

use App\Shared\Domain\Exception\AbstractException;

class CommentRouteNotFoundException extends AbstractException
{
    public function __construct(int $id)
    {
        parent::__construct('Comments in Route with id:"' . $id . '" do not exist', 404);
    }
}