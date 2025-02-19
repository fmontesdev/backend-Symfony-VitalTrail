<?php

declare(strict_types=1);

namespace App\Auth\Application\InputPort;

use App\Auth\Application\Dto\UserDto;

interface UserService
{
    public function registerUser(UserDto $data): UserDto;
    public function loginUser(UserDto $data): UserDto;
    public function getCurrentUser(): UserDto;
    public function updateCurrentUser(UserDto $data): UserDto;
}