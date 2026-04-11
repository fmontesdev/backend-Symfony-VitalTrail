<?php

declare(strict_types=1);

namespace App\Admin\Application\Dto;

use App\Admin\Application\Config\AdminConfig;
use Symfony\Component\Serializer\Annotation\Groups;

final class RouteGrowthPointDto
{
    public function __construct(
        #[Groups([AdminConfig::GROWTH_OUTPUT])]
        public string $month = '',
        #[Groups([AdminConfig::GROWTH_OUTPUT])]
        public int $newRoutes = 0,
    ) {
    }
}
