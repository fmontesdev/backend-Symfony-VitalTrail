<?php

declare(strict_types=1);

namespace App\Routes\Domain\OutputPort;

use App\Routes\Domain\Entity\ImageRoute;

interface ImageRouteRepository
{
    public function findById(int $idImg): ?ImageRoute;
    public function findImagesByRoute(int $idRoute): array;
    public function save(ImageRoute $entity): void;
    public function remove(ImageRoute $entity): void;
    public function findExistingImagesInRoute(int $idRoute, array $images): array;
}
