<?php

declare(strict_types=1);

namespace App\Shared\Application\Exception;

use App\Shared\Domain\Exception\AbstractException;

final class UploadDirectoryNotWritableException extends AbstractException
{
    public function __construct(string $directory)
    {
        parent::__construct(
            sprintf('Upload directory "%s" is not writable', $directory),
            500
        );
    }
}
