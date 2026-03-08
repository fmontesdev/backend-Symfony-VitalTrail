<?php

declare(strict_types=1);

namespace App\Sessions\Application\UseCase\Command\CreateCheckin;

use App\Security\Domain\Exception\NotAuthorizedResourceException;
use App\Sessions\Application\Dto\WellbeingCheckinDto;
use App\Sessions\Application\Exception\CheckinAlreadyExistsException;
use App\Sessions\Application\Exception\InvalidCheckinValueException;
use App\Sessions\Application\Service\RouteSessionService;
use App\Sessions\Application\Service\WellbeingCheckinService;
use App\Sessions\Domain\Entity\WellbeingCheckin;
use App\Sessions\Domain\OutputPort\WellbeingCheckinRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class CreateCheckinCommandHandler
{
    public function __construct(
        private readonly RouteSessionService $routeSessionService,
        private readonly WellbeingCheckinRepository $wellbeingCheckinRepository,
        private readonly WellbeingCheckinService $wellbeingCheckinService,
    ) {
    }

    public function __invoke(CreateCheckinCommand $command): WellbeingCheckinDto
    {
        $session = $this->routeSessionService->findSessionSafe($command->idSession);

        if (!$this->routeSessionService->isAuthorized($session)) {
            throw new NotAuthorizedResourceException();
        }

        $existing = $this->wellbeingCheckinRepository->findBySession($command->idSession);
        if ($existing !== null) {
            throw new CheckinAlreadyExistsException($command->idSession);
        }

        $checkin = new WellbeingCheckin();
        $checkin->setSession($session);

        try {
            $checkin->setEnergy($command->energy);
            $checkin->setStress($command->stress);
            $checkin->setMood($command->mood);
            $checkin->setNotes($command->notes);
        } catch (\InvalidArgumentException $e) {
            throw new InvalidCheckinValueException($e->getMessage());
        }

        $this->wellbeingCheckinRepository->save($checkin);

        return $this->wellbeingCheckinService->toDto($checkin);
    }
}
