<?php

declare(strict_types=1);

namespace App\Profiles\Application\Service;

use App\Auth\Domain\Entity\User;
use App\Profiles\Domain\OutputPort\FollowRepository;
use App\Security\Application\SecurityContext;
use App\Security\Domain\Exception\UserIsNotAuthenticatedException;

class FollowService
{
    public function __construct(
        private readonly FollowRepository $followRepository,
        private readonly SecurityContext $securityContext
    ) {
    }

    public function getContextUser(): User
    {
        return $this->securityContext->getAuthenticatedUser();
    }

    public function isFollowing(User $followed): bool
    {
        // Usuario actual
        $follower = $this->getContextUser();
        if ($follower === null) {
            throw new UserIsNotAuthenticatedException();
        }

        return $this->followRepository->exists($follower, $followed);
    }

    public function follow(User $follower, User $followed): void
    {
        $this->followRepository->add($follower, $followed);
    }

    public function unfollow(User $follower, User $followed): void
    {
        $this->followRepository->remove($follower, $followed);
    }

    public function followersCount(User $followed): int
    {
        
        return $this->followRepository->countFollowers($followed);
    }

    public function followingsCount(User $follower): int
    {
        return $this->followRepository->countFollowings($follower);
    }
}