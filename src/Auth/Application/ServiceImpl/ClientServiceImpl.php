<?php

declare(strict_types=1);

namespace App\Auth\Application\ServiceImpl;

use App\Auth\Application\Dto\UserDto;
use App\Auth\Application\Dto\ClientDto;
use App\Auth\Domain\Entity\User;
use App\Auth\Presentation\Mapper\UserMapper;
use App\Auth\Presentation\Mapper\ClientMapper;
use App\Auth\Domain\OutputPort\UserRepository;
use App\Auth\Domain\OutputPort\ClientRepository;

class ClientServiceImpl
{
    public function __construct(
        private UserMapper $userMapper,
        private ClientMapper $clientMapper,
        private UserRepository $userRepository,
        private ClientRepository $clientRepository,
    ) {
    }

    public function registerClient(User $user, UserDto $data = null): User
    {
        // Registra nuevo Client
        $clientDto = new ClientDto();
        $clientDto->user = $this->userMapper->mapEntityToDto($user); // Asigna el usuario creado
        $clientDto->phone = $data->client->phone;
        $client = $this->clientMapper->mapDtoToEntity($clientDto);
        $this->clientRepository->save($client);

        // Asigna el Client al User
        $user->setClient($client);
        $this->userRepository->save($user);
        return  $user;
    }
}
