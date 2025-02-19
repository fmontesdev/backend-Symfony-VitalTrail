<?php

declare(strict_types=1);

namespace App\Routes\Application\UseCase\Command\CreateComment;

use App\Shared\Application\Command\BaseCommand;
use App\Routes\Application\Dto\CommentDto;

final class CreateCommentCommand implements BaseCommand
{
    public function __construct(
        public readonly CommentDto $data,
        public readonly string $slug,
    ) {}
}