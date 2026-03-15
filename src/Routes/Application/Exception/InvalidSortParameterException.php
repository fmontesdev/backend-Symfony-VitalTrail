<?php

declare(strict_types=1);

namespace App\Routes\Application\Exception;

use App\Shared\Domain\Exception\AbstractException;

final class InvalidSortParameterException extends AbstractException
{
    public function __construct(string $param, string $value)
    {
        parent::__construct('Invalid value "' . $value . '" for sort parameter "' . $param . '"', 400);
    }
}
