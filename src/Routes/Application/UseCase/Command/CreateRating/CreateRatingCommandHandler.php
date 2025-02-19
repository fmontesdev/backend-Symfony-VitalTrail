<?php

declare(strict_types=1);

namespace App\Routes\Application\UseCase\Command\CreateRating;

use App\Routes\Application\UseCase\Command\CreateRating\CreateRatingCommand;
use App\Routes\Domain\Entity\Rating;
use App\Routes\Domain\Entity\Comment;
use App\Routes\Application\Dto\RatingDto;
use App\Routes\Domain\OutputPort\RatingRepository;
use App\Routes\Domain\OutputPort\CommentRepository;
use App\Routes\Domain\OutputPort\RouteRepository;
use App\Routes\Application\Service\RatingService;
use App\Routes\Application\Service\CommentService;
use App\Routes\Application\Service\RouteService;
use App\Security\Domain\Exception\UserIsNotAuthenticatedException;
use App\Routes\Application\Exception\RouteNotFoundException;
use App\Routes\Application\Exception\CommentRouteNotFoundException;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class CreateRatingCommandHandler
{
    public function __construct(
        private readonly RatingRepository $ratingRepository,
        private readonly CommentRepository $commentRepository,
        private readonly RouteRepository $routeRepository,
        private readonly RatingService $ratingService,
        private readonly CommentService $commentService,
        private readonly RouteService $routeService
        
    ) {
    }

    /**
     * Añadir rating a una ruta
     *
     * @param CreateRatingCommand $command
     * @return RatingDto[]
     */
    public function __invoke(CreateRatingCommand $command): array
    {
        // Recupera el usuario actual
        $currentUser = $this->routeService->getContextUser();
        if ($currentUser === null) {
            throw new UserIsNotAuthenticatedException();
        }

        // Verifica si la ruta existe
        $route = $this->routeRepository->findBySlug($command->slugRoute);
        if (!$route) {
            throw new RouteNotFoundException($command->slugRoute);
        }

        // Crea el comentario en la base de datos si existe
        if ($command->data->body) {
            $comment = $this->commentService->save($command->data->body, $currentUser, $route, null);
        }

        // Guarda el rating en la base de datos
        $rating = $this->ratingService->save($command->data->rating, $currentUser, $route, $comment, null);

        // Guarda el rating en el comentario
        $comment = $this->commentService->saveRating($comment, $rating);

        // Obtiene todos los comentarios con los ratings de la ruta
        $comments = $this->commentRepository->findCommentsByRoute($route->getIdRoute());
        if (empty($comments)) {
            throw new CommentRouteNotFoundException($route->getIdRoute() );
        }
        return array_map(fn (Comment $comment) => $this->commentService->toDto($comment), $comments);
    }
}
