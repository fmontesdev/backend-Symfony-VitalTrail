<?php

declare(strict_types=1);

namespace App\Routes\Application\UseCase\Command\DeleteComment;

use App\Shared\Application\Command\BaseCommand;

final class DeleteCommentCommand implements BaseCommand
{
    public function __construct(
        public readonly int $idComment
    ) {}
}