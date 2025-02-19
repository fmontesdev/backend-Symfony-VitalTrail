<?php

declare(strict_types=1);

namespace App\Profiles\Domain\Entity;

use App\Profiles\Domain\Repository\UserRepository;
use App\Auth\Domain\Entity\User;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: 'follows')]
class Follow
{
    #[ORM\Id]
    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: 'id_follower', referencedColumnName: 'id_user', onDelete: 'CASCADE')]
    private User $follower;

    #[ORM\Id]
    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: 'id_followed', referencedColumnName: 'id_user', onDelete: 'CASCADE')]
    private User $followed;

    public function getFollower(): User
    {
        return $this->follower;
    }

    public function setFollower(User $follower): void
    {
        $this->follower = $follower;
    }

    public function getFollowed(): User
    {
        return $this->followed;
    }

    public function setFollowed(User $followed): void
    {
        $this->followed = $followed;
    }
}
