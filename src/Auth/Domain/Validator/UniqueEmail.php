<?php

declare(strict_types=1);

namespace App\Auth\Domain\Validator;

use Symfony\Component\Validator\Constraint;

#[\Attribute]
class UniqueEmail extends Constraint
{
    public string $message = 'The email "{{ email }}" is already registered.';
}