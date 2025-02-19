<?php

declare(strict_types=1);

namespace App\Profiles\Presentation\Mapper;

use App\Auth\Domain\Entity\User;
use App\Profiles\Application\Dto\ProfileDto;
use App\Auth\Presentation\Mapper\AdminMapper;
use App\Auth\Presentation\Mapper\ClientMapper;
use App\Profiles\Application\Service\FollowService;

class ProfileMapper
{
    public function __construct(
        private FollowService $followService,
        private AdminMapper $adminMapper,
        private ClientMapper $clientMapper,
    ) {
    }

    public function mapEntityToDto(User $entity): ProfileDto
    {
        $result = new ProfileDto();
        $result->email = $entity->getEmail();
        $result->username = $entity->getUsername();
        $result->name = $entity->getName();
        $result->surname = $entity->getSurname();
        $result->birthday = $entity->getBirthday();
        $result->bio = $entity->getBio();
        $result->imgUser = $entity->getImgUser();
        if($entity->getAdmin() !== null) {
            $result->admin = $this->adminMapper->mapEntityToDto($entity->getAdmin());
        }
        if($entity->getClient() !== null) {
            $result->client = $this->clientMapper->mapEntityToDto($entity->getClient());
        }
        $result->following = $this->followService->isFollowing($entity);
        $result->countFollowers = $this->followService->followersCount($entity);
        $result->countFollowings = $this->followService->followingsCount($entity);
        return $result;
    }
}
