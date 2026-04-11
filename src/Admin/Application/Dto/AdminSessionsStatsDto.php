<?php

declare(strict_types=1);

namespace App\Admin\Application\Dto;

use App\Admin\Application\Config\AdminConfig;
use Symfony\Component\Serializer\Annotation\Groups;

final class AdminSessionsStatsDto
{
    public function __construct(
        #[Groups([AdminConfig::STATS_OUTPUT])]
        public int $total = 0,
        #[Groups([AdminConfig::STATS_OUTPUT])]
        public int $thisMonth = 0,
        #[Groups([AdminConfig::STATS_OUTPUT])]
        public int $totalKm = 0,
    ) {
    }
}
