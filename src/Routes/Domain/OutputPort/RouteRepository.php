<?php

declare(strict_types=1);

namespace App\Routes\Domain\OutputPort;

use App\Routes\Domain\Entity\Route;

interface RouteRepository
{
    public function findById(int $idRoute): ?Route;
    public function findBySlug(string $slug): ?Route;
    public function findAllRoutes(int $limit, int $offset, string $category, string $location, string $title, int $distance, string $difficulty, string $typeRoute, string $autho): array;
    public function save(Route $route): void;
    public function remove(Route $route): void;
    public function countRoutes(string $category, string $location, string $title, int $distance, string $difficulty, string $typeRoute, string $author): int;
}
