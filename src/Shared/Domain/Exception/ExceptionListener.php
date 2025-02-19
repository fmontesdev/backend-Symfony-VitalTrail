<?php

declare(strict_types=1);

namespace App\Shared\Domain\Exception;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Throwable;

class ExceptionListener
{
    private function getStatusCode(Throwable $exception): int
    {
        if ($exception instanceof HttpExceptionInterface) {
            return $exception->getStatusCode();
        }

        return $exception->getCode() ?: Response::HTTP_INTERNAL_SERVER_ERROR;
    }

    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();
        $statusCode = $this->getStatusCode($exception);
        $message = $exception->getMessage() ?: 'An error occurred';

        $response = new JsonResponse(['error' => $message], $statusCode);
        $event->setResponse($response);
    }
}