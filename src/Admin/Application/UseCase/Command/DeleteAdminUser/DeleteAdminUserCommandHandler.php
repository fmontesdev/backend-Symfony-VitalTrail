<?php

declare(strict_types=1);

namespace App\Admin\Application\UseCase\Command\DeleteAdminUser;

use App\Auth\Domain\OutputPort\UserRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class DeleteAdminUserCommandHandler
{
    public function __construct(
        private UserRepository $userRepository,
    ) {
    }

    public function __invoke(DeleteAdminUserCommand $command): void
    {
        $user = $this->userRepository->findById($command->userId);

        if ($user === null) {
            throw new \RuntimeException('User not found', 404);
        }

        $user->setIsDeleted(true);
        $user->setIsActive(false);

        $this->userRepository->save($user);
    }
}
