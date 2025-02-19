<?php

declare(strict_types=1);

namespace App\Auth\Application\ServiceImpl;

use App\Auth\Application\Dto\UserDto;
use App\Auth\Application\Dto\AdminDto;
use App\Auth\Domain\Entity\User;
use App\Auth\Presentation\Mapper\UserMapper;
use App\Auth\Presentation\Mapper\AdminMapper;
use App\Auth\Domain\OutputPort\UserRepository;
use App\Auth\Domain\OutputPort\AdminRepository;

class AdminServiceImpl
{
    public function __construct(
        private UserMapper $userMapper,
        private AdminMapper $adminMapper,
        private UserRepository $userRepository,
        private AdminRepository $adminRepository,
    ) {
    }

    public function registerAdmin(User $user, UserDto $data = null): User
    {
        // Registra nuevo Admin
        $adminDto = new AdminDto();
        $adminDto->user = $this->userMapper->mapEntityToDto($user); // Asigna el usuario creado
        $admin = $this->adminMapper->mapDtoToEntity($adminDto);
        $this->adminRepository->save($admin);

        // Asigna el Admin al User
        $user->setAdmin($admin);
        $this->userRepository->save($user);
        return  $user;
    }
}
