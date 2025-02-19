<?php

declare(strict_types=1);

namespace App\Routes\Application\Exception;

use App\Shared\Domain\Exception\AbstractException;

class RatingNotFoundException extends AbstractException
{
    public function __construct(int $id)
    {
        parent::__construct('Rating with id:"' . $id . '" does not exist', 404);
    }
}