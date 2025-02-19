<?php

declare(strict_types=1);

namespace App\Routes\Application\UseCase\Command\DeleteComment;

use App\Routes\Application\UseCase\Command\DeleteComment\DeleteCommentCommand;
use App\Routes\Domain\OutputPort\CommentRepository;
use App\Routes\Domain\OutputPort\RouteRepository;
use App\Routes\Application\Service\CommentService;
use App\Routes\Application\Exception\RouteNotFoundException;
use App\Routes\Application\Exception\CommentNotFoundException;
use App\Security\Domain\Exception\NotAuthorizedResourceException;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class DeleteCommentCommandHandler
{
    public function __construct(
        private readonly CommentRepository $commentRepository,
        private readonly RouteRepository $routeRepository,
        private readonly CommentService $commentService
    ) {
    }

    /**
     * Eliminación de un comentario de una ruta
     *
     * @param DeleteCommentCommand $command
     */
    public function __invoke(DeleteCommentCommand $command): void
    {
        // Verifica si el comentario existe y si el usuario tiene permisos para acceder a ella
        $comment = $this->commentService->findCommentSafe($command->idComment);
        if (!$comment) {
            throw new CommentNotFoundException($command->idComment);
        }
        if (!$this->commentService->isAuthorized($comment)) {
            throw new NotAuthorizedResourceException();
        }
        $this->commentRepository->remove($comment);
    }
}
