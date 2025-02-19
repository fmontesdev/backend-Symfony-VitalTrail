<?php

declare(strict_types=1);

namespace App\Auth\Domain\OutputPort;

use App\Auth\Domain\Entity\User;

interface UserRepository
{
    public function findByEmail(string $email): ?User;
    public function findByUsername(string $username): ?User;
    public function save(User $user): void;
}
