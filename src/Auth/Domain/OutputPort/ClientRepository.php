<?php

declare(strict_types=1);

namespace App\Auth\Domain\OutputPort;

use App\Auth\Domain\Entity\Client;

interface ClientRepository
{
    public function save(Client $client): void;
}
