<?php

declare(strict_types=1);

namespace App\Sessions\Domain\OutputPort;

use App\Sessions\Domain\Entity\RouteSession;
use Symfony\Component\Uid\Uuid;

interface RouteSessionRepository
{
    public function findById(int $idSession): ?RouteSession;
    public function findByUser(Uuid $idUser): array;
    public function findByRoute(int $idRoute): array;
    public function save(RouteSession $entity): void;
    public function remove(RouteSession $entity): void;
}
