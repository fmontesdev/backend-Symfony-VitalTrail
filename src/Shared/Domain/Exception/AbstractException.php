<?php

declare(strict_types=1);

namespace App\Shared\Domain\Exception;

use Exception;
use Throwable;

abstract class AbstractException extends Exception
{
    public function __construct(string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        $exceptionMessage = $message ?: $this->message;
        $exceptionCode = $code ?: $this->code;
        parent::__construct($exceptionMessage, $exceptionCode, $previous);
    }
}
