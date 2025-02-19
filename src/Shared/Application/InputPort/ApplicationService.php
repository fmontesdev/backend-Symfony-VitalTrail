<?php

declare(strict_types=1);

namespace App\Shared\Application\InputPort;

interface ApplicationService
{
    public function handle(object $message): mixed;
}
