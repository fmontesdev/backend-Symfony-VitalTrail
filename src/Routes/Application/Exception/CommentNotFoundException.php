<?php

declare(strict_types=1);

namespace App\Routes\Application\Exception;

use App\Shared\Domain\Exception\AbstractException;

class CommentNotFoundException extends AbstractException
{
    public function __construct(int $id)
    {
        parent::__construct('Comment with id:"' . $id . '" does not exist', 404);
    }
}