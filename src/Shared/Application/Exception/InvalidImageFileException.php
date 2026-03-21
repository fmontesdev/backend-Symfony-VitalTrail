<?php

declare(strict_types=1);

namespace App\Shared\Application\Exception;

use App\Shared\Domain\Exception\AbstractException;

final class InvalidImageFileException extends AbstractException
{
    public function __construct(string $reason = 'Invalid or unsupported image file')
    {
        parent::__construct($reason, 422);
    }
}
