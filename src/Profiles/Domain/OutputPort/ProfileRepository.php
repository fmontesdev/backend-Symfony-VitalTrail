<?php

declare(strict_types=1);

namespace App\Profiles\Domain\OutputPort;

use App\Auth\Domain\Entity\User;

interface ProfileRepository
{
    public function findAllFollowerProfiles(string $username): array;
    public function findAllFollowingProfiles(string $username): array;
    public function countFollowerProfiles(string $username): int;
    public function countFollowingProfiles(string $username): int;
}
