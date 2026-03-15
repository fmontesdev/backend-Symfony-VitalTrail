<?php

declare(strict_types=1);

namespace App\Stats\Application\Dto;

use App\Stats\Application\Config\StatsConfig;
use Symfony\Component\Serializer\Annotation\Groups;

final class StatsDto
{
    public function __construct(
        #[Groups([StatsConfig::OUTPUT])]
        public int $totalRoutes = 0,
        #[Groups([StatsConfig::OUTPUT])]
        public int $totalCategories = 0,
        #[Groups([StatsConfig::OUTPUT])]
        public int $totalActiveUsers = 0,
        #[Groups([StatsConfig::OUTPUT])]
        public int $totalKm = 0,
    ) {
    }
}
