<?php

declare(strict_types=1);

namespace App\Routes\Presentation\Mapper;

use App\Routes\Domain\Entity\Comment;
use App\Routes\Application\Dto\CommentDto;
use App\Auth\Presentation\Mapper\UserMapper;

class CommentMapper
{
    public function __construct(
        private UserMapper $userMapper,
    ) {
    }

    public function mapDtoToEntity(CommentDto $dto, ?Comment $entity = null): Comment
    {
        $result = $entity ?: new Comment();
        if ($dto->user !== null) {
            $result->setUser($dto->user);
        }
        if ($dto->route !== null) {
            $result->setRoute($dto->route);
        }
        if ($dto->body !== null) {
            $result->setBody($dto->body);
        }
        return $result;
    }

    public function mapEntityToDto(Comment $entity): CommentDto
    {
        $result = new CommentDto();
        $result->idComment= $entity->getIdComment();
        if ($entity->getUser() !== null) {
            $result->user = $this->userMapper->mapEntityToDto($entity->getUser());
        }
        // $result->user = $entity->getUser()->getIdUser();
        $result->route = $entity->getRoute()->getIdRoute();
        $result->body = $entity->getBody();
        $entity->getRating() !== null ? $result->rating = $entity->getRating()->getRating() : null;
        $result->createdAt = $entity->getCreatedAt();
        return $result;
    }

    public function mapEntitiesToDtoArray(iterable $comments): array
    {
        $result = [];
        foreach ($comments as $comment) {
            $result[] = $this->mapEntityToDto($comment);
        }
        rsort($result);
        return $result;
    }
}
