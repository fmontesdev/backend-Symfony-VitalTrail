<?php

declare(strict_types=1);

namespace App\Auth\Presentation\Mapper;

use App\Auth\Application\Dto\UserDto;
use App\Auth\Domain\Entity\User;
use App\Auth\Domain\Enum\RolUserEnum;
use App\Auth\Presentation\Mapper\AdminMapper;
use App\Auth\Presentation\Mapper\ClientMapper;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserMapper
{
    public function __construct(
        private AdminMapper $adminMapper,
        private ClientMapper $clientMapper,
        private UserPasswordHasherInterface $passwordHasher
    ) {
    }

    public function mapDtoToEntity(UserDto $dto, ?User $entity = null): User
    {
        $result = $entity ?: new User();
        if ($dto->email !== null) {
            $result->setEmail($dto->email);
        }
        if ($dto->username !== null) {
            $result->setUsername($dto->username);
        }
        if ($dto->password !== null) {
            $result->setPassword($dto->password);
        }
        if ($dto->name !== null) {
            $result->setName($dto->name);
        }
        if ($dto->surname !== null) {
            $result->setSurname($dto->surname);
        }
        if ($dto->birthday !== null) {
            $result->setBirthday($dto->birthday);
        }
        if ($dto->bio !== null) {
            $result->setBio($dto->bio);
        }
        if ($dto->imgUser !== null) {
            $result->setImgUser($dto->imgUser);
        }
        if ($dto->rol !== null) {
            $result->setRol(RolUserEnum::from($dto->rol));
        }
        if ($dto->isActive !== null) {
            $result->setIsActive($dto->isActive);
        }
        if ($dto->isDeleted !== null) {
            $result->setIsDeleted($dto->isDeleted);
        }
        if ($dto->isPremium !== null) {
            $result->setIsPremium($dto->isPremium);
        }
        // if ($dto->admin !== null) {
        //     $result->setAdmin($this->adminMapper->mapDtoToEntity($dto->admin));
        // }
        // if ($dto->client !== null) {
        //     $result->setClient($this->clientMapper->mapDtoToEntity($dto->client));
        // }
        return $result;
    }

    public function mapEntityToDto(User $entity): UserDto
    {
        $result = new UserDto();
        $result->idUser = $entity->getIdUser();
        $result->email = $entity->getEmail();
        $result->username = $entity->getUsername();
        $result->name = $entity->getName();
        $result->surname = $entity->getSurname();
        $result->birthday = $entity->getBirthday();
        $result->bio = $entity->getBio();
        $result->imgUser = $entity->getImgUser();
        $result->rol = $entity->getRol()?->value;
        $result->isActive = $entity->getIsActive();
        $result->isDeleted = $entity->getIsDeleted();
        $result->isPremium = $entity->getIsPremium();
        if($entity->getAdmin() !== null) {
            $result->admin = $this->adminMapper->mapEntityToDto($entity->getAdmin());
        }
        if($entity->getClient() !== null) {
            $result->client = $this->clientMapper->mapEntityToDto($entity->getClient());
        }
        return $result;
    }
}
