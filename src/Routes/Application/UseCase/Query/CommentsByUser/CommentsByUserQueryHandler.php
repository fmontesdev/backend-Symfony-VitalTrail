<?php

declare(strict_types=1);

namespace App\Routes\Application\UseCase\Query\CommentsByUser;

use App\Routes\Application\UseCase\Query\CommentsByUser\CommentsByUserQuery;
use App\Routes\Domain\Entity\Comment;
use App\Routes\Application\Dto\CommentDto;
use App\Routes\Domain\OutputPort\CommentRepository;
use App\Profiles\Application\Service\ProfileService;
use App\Routes\Application\Service\CommentService;
use App\Security\Domain\Exception\NotAuthorizedResourceException;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class CommentsByUserQueryHandler
{
    public function __construct(
        private readonly CommentRepository $commentRepository,
        private readonly CommentService $commentService,
        private readonly ProfileService $profileService
    ) {
    }

    /**
     * Selecciona todos los comentarios de una ruta
     *
     * @param CommentsByUserQuery $query
     * @return CommentDto[]|null
     */
    public function __invoke(CommentsByUserQuery $query): ?array
    {
        // Comprueba que el profile existe
        $user = $this->profileService->findProfileSafe((string) $query->username);

        // Comprueba que el usuario es el propietario del profile
        if (!$this->commentService->isOwner($user)) {
            throw new NotAuthorizedResourceException();
        }

        // Obtiene los comentarios del usuario
        $comments = $this->commentRepository->findCommentsByUser($user->getIdUser());
        if (!$comments) {
            return null;
        }
        return array_map(fn (Comment $comment) => $this->commentService->toDto($comment), $comments);
    }
}
