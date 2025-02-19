<?php

declare(strict_types=1);

namespace App\Auth\Domain\OutputPort;

use App\Auth\Domain\Entity\Admin;

interface AdminRepository
{
    public function save(Admin $admin): void;
}
