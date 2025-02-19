<?php

declare(strict_types=1);

namespace App\Routes\Domain\OutputPort;

use App\Routes\Domain\Entity\CategoryRoute;

interface CategoryRouteRepository
{
    public function findByTitle(string $title): ?CategoryRoute;
    public function findAllCategoryRoutes(): array;
}
