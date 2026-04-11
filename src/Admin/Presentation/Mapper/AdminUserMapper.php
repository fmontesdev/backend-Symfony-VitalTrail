<?php

declare(strict_types=1);

namespace App\Admin\Presentation\Mapper;

use App\Admin\Application\Dto\AdminUserDto;
use App\Admin\Application\Dto\AdminUsersPageDto;
use App\Admin\Presentation\InputAdapter\Resource\AdminUsersPageResource;
use App\Auth\Domain\Entity\User;

final class AdminUserMapper
{
    public static function mapEntityToDto(User $user): AdminUserDto
    {
        $dto = new AdminUserDto();
        $dto->idUser = (string) $user->getIdUser();
        $dto->username = $user->getUsername();
        $dto->email = $user->getEmail();
        $dto->name = $user->getName();
        $dto->surname = $user->getSurname();
        $dto->imgUser = $user->getImgUser();
        $dto->rol = $user->getRol()?->value;
        $dto->isPremium = $user->getIsPremium();
        $dto->isActive = $user->getIsActive();
        $dto->isDeleted = $user->getIsDeleted();
        $dto->createdAt = $user->getCreatedAt();

        return $dto;
    }

    public static function mapPageDtoToResource(AdminUsersPageDto $dto): AdminUsersPageResource
    {
        $resource = new AdminUsersPageResource();
        $resource->users = $dto->users;
        $resource->total = $dto->total;
        $resource->page = $dto->page;
        $resource->limit = $dto->limit;

        return $resource;
    }
}
