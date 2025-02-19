<?php

declare(strict_types=1);

namespace App\Profiles\Domain\OutputPort;

use App\Auth\Domain\Entity\User;

interface FollowRepository
{
    public function exists(User $follower, User $followed): bool;
    public function add(User $follower, User $followed): void;
    public function remove(User $follower, User $followed): void;
    public function countFollowers(User $followed): int;
    public function countFollowings(User $follower): int;
}
