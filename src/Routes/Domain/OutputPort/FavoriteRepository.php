<?php

declare(strict_types=1);

namespace App\Routes\Domain\OutputPort;

use App\Routes\Domain\Entity\Route;
use App\Auth\Domain\Entity\User;

interface FavoriteRepository
{
    public function exists(Route $route, User $user): bool;
    public function add(Route $route, User $user): void;
    public function remove(Route $route, User $user): void;
    public function countByRoute(Route $route): int;
}
