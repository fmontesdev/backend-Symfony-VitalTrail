<?php

declare(strict_types=1);

namespace App\Shared\Application\ServiceImpl;

use App\Shared\Application\InputPort\ApplicationService;
use App\Shared\Application\Command\BaseCommand;
use App\Shared\Application\Query\BaseQuery;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Symfony\Component\Messenger\Envelope;

class ApplicationServiceImpl implements ApplicationService
{
    public function __construct(
        private readonly MessageBusInterface $commandBus,
        private readonly MessageBusInterface $queryBus
    ) {
    }

    public function handle(object $message): mixed
    {
        return match (true) {
            $message instanceof BaseCommand => $this->dispatchMessage($this->commandBus, $message),
            $message instanceof BaseQuery => $this->dispatchMessage($this->queryBus, $message),
            default => throw new \InvalidArgumentException(
                sprintf('Message of type %s is not a valid Command or Query', get_class($message))
            ),
        };
    }

    private function dispatchMessage(MessageBusInterface $bus, object $message): mixed
    {
        $envelope = $bus->dispatch($message);
        return $this->extractResult($envelope);
    }

    private function extractResult(Envelope $envelope): mixed
    {
        /** @var HandledStamp|null $stamp */
        $stamp = $envelope->last(HandledStamp::class);
        return $stamp?->getResult();
    }
}
