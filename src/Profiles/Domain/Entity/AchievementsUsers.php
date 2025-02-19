<?php

declare(strict_types=1);

namespace App\Profiles\Domain\Entity;

use App\Profiles\Domain\Repository\AchievementRepository;
use App\Auth\Domain\Entity\User;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AchievementRepository::class)]
#[ORM\Table(name: 'achievements_users')]
class AchievementsUsers
{
    #[ORM\Id]
    #[ORM\ManyToOne(targetEntity: Achievement::class)]
    #[ORM\JoinColumn(name: 'id_achievements', referencedColumnName: 'id_achievements', onDelete: 'CASCADE')]
    private Achievement $achievement;

    #[ORM\Id]
    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: 'id_user', referencedColumnName: 'id_user', onDelete: 'CASCADE')]
    private User $user;
}
