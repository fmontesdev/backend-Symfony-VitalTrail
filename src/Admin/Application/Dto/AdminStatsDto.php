<?php

declare(strict_types=1);

namespace App\Admin\Application\Dto;

use App\Admin\Application\Config\AdminConfig;
use Symfony\Component\Serializer\Annotation\Groups;

final class AdminStatsDto
{
    public function __construct(
        #[Groups([AdminConfig::STATS_OUTPUT])]
        public AdminUsersStatsDto $users,
        #[Groups([AdminConfig::STATS_OUTPUT])]
        public AdminRoutesStatsDto $routes,
        #[Groups([AdminConfig::STATS_OUTPUT])]
        public AdminSessionsStatsDto $sessions,
    ) {
    }
}
