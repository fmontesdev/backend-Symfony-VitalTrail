<?php

declare(strict_types=1);

namespace App\Auth\Presentation\Mapper;

use App\Auth\Domain\Entity\Admin;
use App\Auth\Domain\Entity\User;
use App\Auth\Application\Dto\AdminDto;
use App\Auth\Application\Dto\UserDto;
use Doctrine\ORM\EntityManagerInterface;

class AdminMapper
{
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {
    }

    // private function toUserDto(Admin $entity): UserDto
    // {
    //     $userDto = new UserDto();
    //     $userDto->idUser = $entity->getUser()->getIdUser();
    //     return $userDto;
    // }

    private function toUserEntity(UserDto $dto): User
    {
        // Buscar la entidad User existente en lugar de crear una nueva
        $user = $this->entityManager->getReference(User::class, $dto->idUser);
        return $user;
    }

    public function mapDtoToEntity(AdminDto $dto, ?Admin $entity = null): Admin
    {
        $result = $entity ?: new Admin();
        if ($dto->user !== null) {
            $result->setUser($this->toUserEntity($dto->user));
        }
        return $result;
    }

    public function mapEntityToDto(Admin $entity): AdminDto
    {
        $result = new AdminDto();
        $result->idAdmin = $entity->getIdAdmin();
        $result->user = $entity->getUser()->getIdUser();
        return $result;
    }
}
