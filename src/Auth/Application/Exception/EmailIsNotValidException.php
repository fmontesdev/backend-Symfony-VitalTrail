<?php

declare(strict_types=1);

namespace App\Auth\Application\Exception;

use App\Shared\Domain\Exception\AbstractException;

class EmailIsNotValidException extends AbstractException
{
    public function __construct()
    {
        parent::__construct('Email is not valid', 401);
    }
}