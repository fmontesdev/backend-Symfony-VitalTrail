<?php

declare(strict_types=1);

namespace App\Auth\Domain\Validator;

use Symfony\Component\Validator\Constraint;

#[\Attribute]
class UniqueUsername extends Constraint
{
    public string $message = 'The username "{{ username }}" is already occupied.';
}
