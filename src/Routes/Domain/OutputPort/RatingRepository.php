<?php

declare(strict_types=1);

namespace App\Routes\Domain\OutputPort;

use App\Routes\Domain\Entity\Rating;

interface RatingRepository
{
    public function findById(int $idRating): ?Rating;
    public function findRatingsByRoute(int $idRoute): ?array;
    public function save(Rating $entity): void;
    public function remove(Rating $entity): void;
    public function averageRatings(int $idRoute): float;
}
