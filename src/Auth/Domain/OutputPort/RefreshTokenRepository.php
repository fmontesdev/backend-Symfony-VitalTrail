<?php

declare(strict_types=1);

namespace App\Auth\Domain\OutputPort;

use App\Auth\Domain\Entity\RefreshToken;

interface RefreshTokenRepository
{
    public function findByUsername(string $username): ?RefreshToken;
    public function findByRefreshToken(string $refreshToken): ?RefreshToken;
    public function save(RefreshToken $refreshToken): void;
    public function findInvalid($datetime = null): array;
}
