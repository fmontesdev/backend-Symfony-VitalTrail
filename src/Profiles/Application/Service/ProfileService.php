<?php

declare(strict_types=1);

namespace App\Profiles\Application\Service;

use App\Auth\Domain\Entity\User;
use App\Profiles\Application\Dto\ProfileDto;
use App\Profiles\Presentation\Mapper\ProfileMapper;
use App\Auth\Domain\OutputPort\UserRepository;
use App\Security\Application\SecurityContext;
use App\Profiles\Application\Exception\ProfileNotFoundException;

class ProfileService
{
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly SecurityContext $securityContext,
        private readonly ProfileMapper $profileMapper
    ) {
    }

    public function getContextUser(): User
    {
        return $this->securityContext->getAuthenticatedUser();
    }

    public function findProfileSafe(string $username): ?User
    {
        $profile = $this->userRepository->findByUsername($username);
        if ($profile === null) {
            throw new ProfileNotFoundException($username );
        }
        return $profile;
    }

    public function toDto(User $entity): ProfileDto
    {
        return $this->profileMapper->mapEntityToDto($entity);
    }
}
