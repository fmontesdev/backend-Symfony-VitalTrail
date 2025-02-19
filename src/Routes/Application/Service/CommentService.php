<?php

declare(strict_types=1);

namespace App\Routes\Application\Service;

use App\Routes\Domain\Entity\Comment;
use App\Routes\Domain\Entity\Rating;
use App\Routes\Domain\Entity\Route;
use App\Auth\Domain\Entity\User;
use App\Routes\Application\Dto\CommentDto;
use App\Routes\Presentation\Mapper\CommentMapper;
use App\Routes\Domain\OutputPort\CommentRepository;
use App\Routes\Application\Exception\CommentNotFoundException;
use App\Security\Application\SecurityContext;
use App\Security\Application\AuthorizationService;

class CommentService
{
    public function __construct(
        private readonly CommentRepository $commentRepository,
        private readonly CommentMapper $commentMapper,
        private readonly SecurityContext $securityContext,
        private readonly AuthorizationService $authorizationService
    ) {
    }

    public function getContextUser(): User
    {
        return $this->securityContext->getAuthenticatedUser();
    }

    public function findCommentSafe(int $idComment): ?Comment
    {
        $comment = $this->commentRepository->findById($idComment);
        if ($comment === null) {
            throw new CommentNotFoundException($idComment );
        }
        return $comment;
    }

    public function isOwner(User $entity): bool
    {
        $currentUser = $this->getContextUser();
        return $currentUser->getIdUser() !== $entity->getIdUser() ? false : true;
    }

    public function isAuthorized(Comment $comment): bool
    {
        return $this->authorizationService->isOwner($comment) || $this->securityContext->isAdmin() ? true : false;
    }

    public function save(string $body, User $user, Route $route, ?Comment $entity = null): Comment
    {
        $commentDto = new CommentDto();
        $commentDto->user = $user;
        $commentDto->route = $route;
        $commentDto->body = $body;
        $result = $this->commentMapper->mapDtoToEntity($commentDto, $entity);
        $this->commentRepository->save($result);
        return $result;
    }

    public function saveRating(Comment $commentEntity, Rating $ratingEntity): Comment
    {
        $result = $commentEntity->setRating($ratingEntity);
        $this->commentRepository->save($commentEntity);
        return $result;
    }

    public function toDto(Comment $entity): CommentDto
    {
        return $this->commentMapper->mapEntityToDto($entity);
    }
}
