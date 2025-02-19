<?php

declare(strict_types=1);

namespace App\Routes\Application\UseCase\Command\CreateComment;

use App\Routes\Application\UseCase\Command\CreateComment\CreateCommentCommand;
use App\Routes\Domain\Entity\Comment;
use App\Routes\Application\Dto\CommentDto;
use App\Routes\Domain\OutputPort\CommentRepository;
use App\Routes\Domain\OutputPort\RouteRepository;
use App\Routes\Application\Service\CommentService;
use App\Routes\Application\Service\RouteService;
use App\Security\Domain\Exception\UserIsNotAuthenticatedException;
use App\Routes\Application\Exception\RouteNotFoundException;
use App\Routes\Application\Exception\CommentRouteNotFoundException;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class CreateCommentCommandHandler
{
    public function __construct(
        private readonly CommentRepository $commentRepository,
        private readonly RouteRepository $routeRepository,
        private readonly CommentService $commentService,
        private readonly RouteService $routeService
        
    ) {
    }

    /**
     * Añadir comentario a una ruta
     *
     * @param CreateCommentCommand $command
     * @return CommentDto
     */
    public function __invoke(CreateCommentCommand $command): CommentDto
    {
        // Recupera el usuario actual
        $currentUser = $this->routeService->getContextUser();
        if ($currentUser === null) {
            throw new UserIsNotAuthenticatedException();
        }

        // Verifica si la ruta existe
        $route = $this->routeRepository->findBySlug($command->slug);
        if (!$route) {
            throw new RouteNotFoundException($command->slug);
        }

        // Guarda el comentario en la base de datos
        $comment = $this->commentService->save($command->data->body, $currentUser, $route, null);

        // dd($comment);
        return $this->commentService->toDto($comment);

        // Obtiene los comentarios de la ruta
        // $comments = $this->commentRepository->findCommentsByRoute($route->getIdRoute());
        // if (empty($comments)) {
        //     throw new CommentRouteNotFoundException($route->getIdRoute() );
        // }
        // return array_map(fn (Comment $comment) => $this->commentService->toDto($comment), $comments);
    }
}
