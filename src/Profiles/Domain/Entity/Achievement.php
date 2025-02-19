<?php

declare(strict_types=1);

namespace App\Profiles\Domain\Entity;

use App\Profiles\Domain\Repository\AchievementRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AchievementRepository::class)]
#[ORM\Table(name: 'achievements')]
class Achievement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'id_achievements', type: Types::BIGINT)]
    private ?int $idAchievements = null;

    #[ORM\Column(length: 255)]
    private string $title;

    #[ORM\Column(length: 255)]
    private string $description;

    #[ORM\Column(name: 'img_achievement', length: 255)]
    private string $imgAchievement;
}
