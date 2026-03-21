<?php

declare(strict_types=1);

namespace App\Profiles\Application\UseCase\Command\UploadAvatar;

use App\Auth\Domain\OutputPort\UserRepository;
use App\Profiles\Application\Dto\ProfileDto;
use App\Profiles\Application\Service\ProfileService;
use App\Security\Application\SecurityContext;
use App\Security\Domain\Exception\NotAuthorizedResourceException;
use App\Security\Domain\Exception\UserIsNotAuthenticatedException;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class UploadAvatarCommandHandler
{
    public function __construct(
        private readonly ProfileService $profileService,
        private readonly SecurityContext $securityContext,
        private readonly UserRepository $userRepository,
    ) {
    }

    public function __invoke(UploadAvatarCommand $command): ProfileDto
    {
        $user = $this->profileService->getContextUser();
        if ($user === null) {
            throw new UserIsNotAuthenticatedException();
        }

        if (!$this->securityContext->isAdmin() && $user->getUsername() !== $command->username) {
            throw new NotAuthorizedResourceException();
        }

        $targetUser = $this->securityContext->isAdmin()
            ? $this->profileService->findProfileSafe($command->username)
            : $user;

        $targetUser->setImgUser($command->filename);
        $this->userRepository->save($targetUser);

        return $this->profileService->toDto($targetUser);
    }
}
