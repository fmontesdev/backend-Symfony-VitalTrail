<?php

declare(strict_types=1);

namespace App\Profiles\Application\UseCase\Command\Follow;

use App\Profiles\Application\UseCase\Command\Follow\FollowCommand;
use App\Profiles\Application\Dto\ProfileDto;
use App\Profiles\Application\Service\ProfileService;
use App\Profiles\Application\Service\FollowService;
use App\Security\Domain\Exception\UserIsNotAuthenticatedException;
use App\Profiles\Application\Exception\SelfFollowingForbiddenException;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class FollowCommandHandler
{
    public function __construct(
        private readonly ProfileService $profileService,
        private readonly FollowService $followService,
    ) {
    }

    /**
     * Follow/Unfollow de un profile
     *
     * @param FollowCommand $command
     * @return ProfileDto
     */
    public function __invoke(FollowCommand $command): ProfileDto
    {
        // Recupera el usuario actual (follower)
        $follower = $this->profileService->getContextUser();
        if ($follower === null) {
            throw new UserIsNotAuthenticatedException();
        }
        
        // Verifica que el usuario a seguir existe (followed)
        $followed = $this->profileService->findProfileSafe($command->username);

        if($follower->getIdUser() === $followed->getIdUser()) {
            throw new SelfFollowingForbiddenException();
        }
        
        // Selecciona la acción a realizar según el método HTTP	
        $command->httpMethod !== 'DELETE'
            ? $this->followService->follow($follower, $followed)
            : $this->followService->unfollow($follower, $followed);
    
        return $this->profileService->toDto($followed);
    }
}