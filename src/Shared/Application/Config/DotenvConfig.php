<?php

namespace App\Shared\Application\Config;

use Symfony\Component\Dotenv\Dotenv;

class DotenvConfig
{
    public static function loadEnv(): void
    {
        $dotenv = new Dotenv();
        $dotenv->load(dirname(__DIR__, 2) . '/.env');
    }
}