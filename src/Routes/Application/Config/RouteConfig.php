<?php

declare(strict_types=1);

namespace App\Routes\Application\Config;

final class RouteConfig
{
    public const SLUG_LENGTH = 128;
    public const TITLE_LENGTH = 128;
    public const LOCATION_LENGTH = 128;

    public const INPUT = 'RouteInput';

    public const OUTPUT = 'RouteOutput';
    public const OUTPUT_LIST = 'RouteListOutput';

    public const VALID = 'RouteValid';
}
