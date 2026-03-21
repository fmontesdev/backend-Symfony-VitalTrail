<?php

declare(strict_types=1);

namespace App\Shared\Application\Exception;

use App\Shared\Domain\Exception\AbstractException;

final class InvalidUploadSubdirectoryException extends AbstractException
{
    public function __construct(string $subdirectory)
    {
        parent::__construct(
            sprintf('Unknown upload subdirectory "%s"', $subdirectory),
            500
        );
    }
}
