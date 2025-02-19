<?php

declare(strict_types=1);

namespace App\Routes\Domain\OutputPort;

use Symfony\Component\Uid\Uuid;
use App\Routes\Domain\Entity\Comment;

interface CommentRepository
{
    public function findById(int $idComment): ?Comment;
    public function findCommentsByRoute(int $idRoute): ?array;
    public function findCommentsByUser(Uuid $idUser): ?array;
    public function save(Comment $entity): void;
    public function remove(Comment $entity): void;
}
