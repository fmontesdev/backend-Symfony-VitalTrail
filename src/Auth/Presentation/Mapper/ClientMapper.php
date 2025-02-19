<?php

declare(strict_types=1);

namespace App\Auth\Presentation\Mapper;

use App\Auth\Domain\Entity\Client;
use App\Auth\Domain\Entity\User;
use App\Auth\Application\Dto\ClientDto;
use App\Auth\Application\Dto\UserDto;
use Doctrine\ORM\EntityManagerInterface;

class ClientMapper
{
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {
    }

    // private function toUserDto(Client $entity): UserDto
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

    public function mapDtoToEntity(ClientDto $dto, ?Client $entity = null): Client
    {
        $result = $entity ?: new Client();
        if ($dto->user !== null) {
            $result->setUser($this->toUserEntity($dto->user));
        }
        if ($dto->phone !== null) {
            $result->setPhone($dto->phone);
        }
        return $result;
    }

    public function mapEntityToDto(Client $entity): ClientDto
    {
        $result = new ClientDto();
        $result->idClient = $entity->getIdClient();
        $result->user = $entity->getUser()->getIdUser();
        $result->phone = $entity->getPhone();
        return $result;
    }
}
