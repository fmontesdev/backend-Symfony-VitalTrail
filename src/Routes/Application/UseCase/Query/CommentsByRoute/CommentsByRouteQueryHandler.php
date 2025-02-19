<?php

declare(strict_types=1);

namespace App\Routes\Application\UseCase\Query\CommentsByRoute;

use App\Routes\Application\UseCase\Query\CommentsByRoute\CommentsByRouteQuery;
use App\Routes\Domain\Entity\Comment;
use App\Routes\Application\Dto\CommentDto;
use App\Routes\Domain\OutputPort\CommentRepository;
use App\Routes\Domain\OutputPort\RouteRepository;
use App\Routes\Application\Service\RouteService;
use App\Routes\Application\Service\CommentService;
use App\Routes\Application\Exception\RouteNotFoundException;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class CommentsByRouteQueryHandler
{
    public function __construct(
        private readonly CommentRepository $commentRepository,
        private readonly RouteRepository $routeRepository,
        private readonly CommentService $commentService,
        private readonly RouteService $routeService
    ) {
    }

    /**
     * Selecciona todos los comentarios de una ruta
     *
     * @param CommentsByRouteQuery $query
     * @return CommentDto[]|null
     */
    public function __invoke(CommentsByRouteQuery $query): ?array
    {
        // Verifica si la ruta existe
        $route = $this->routeRepository->findBySlug($query->slug);
        if (!$route) {
            throw new RouteNotFoundException(null);
        }
        
        // Obtiene los comentarios de la ruta
        $comments = $this->commentRepository->findCommentsByRoute($route->getIdRoute());
        if (!$comments) {
            return null;
        }
        return array_map(fn (Comment $comment) => $this->commentService->toDto($comment), $comments);
    }
}
