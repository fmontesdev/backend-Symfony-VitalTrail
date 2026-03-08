<?php

declare(strict_types=1);

namespace App\Sessions\Domain\OutputPort;

use App\Sessions\Domain\Entity\WellbeingCheckin;
use Symfony\Component\Uid\Uuid;

interface WellbeingCheckinRepository
{
    public function findById(int $idCheckin): ?WellbeingCheckin;
    public function findBySession(int $idSession): ?WellbeingCheckin;

    /** @return WellbeingCheckin[] */
    public function findByUser(Uuid $idUser): array;

    public function save(WellbeingCheckin $entity): void;
    public function remove(WellbeingCheckin $entity): void;
}
