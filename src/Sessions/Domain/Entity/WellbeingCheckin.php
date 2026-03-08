<?php

declare(strict_types=1);

namespace App\Sessions\Domain\Entity;

use App\Sessions\Infra\OutputAdapter\Doctrine\WellbeingCheckinRepositoryImpl;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WellbeingCheckinRepositoryImpl::class)]
#[ORM\Table(name: 'wellbeing_checkins')]
#[ORM\HasLifecycleCallbacks]
class WellbeingCheckin
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'id_checkin', type: Types::BIGINT)]
    private ?int $idCheckin = null;

    #[ORM\OneToOne(inversedBy: 'wellbeingCheckin', targetEntity: RouteSession::class, fetch: 'LAZY')]
    #[ORM\JoinColumn(name: 'id_session', referencedColumnName: 'id_session', unique: true, nullable: false, onDelete: 'CASCADE')]
    private ?RouteSession $session = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $energy = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $stress = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $mood = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $notes = null;

    #[ORM\Column(name: 'create_at', type: Types::DATETIME_MUTABLE, options: ['default' => 'CURRENT_TIMESTAMP'])]
    private ?\DateTimeInterface $createAt = null;

    #[ORM\PrePersist]
    public function setTimestampsOnCreate(): void
    {
        $this->createAt = new \DateTimeImmutable();
    }

    public function getIdCheckin(): ?int
    {
        return $this->idCheckin;
    }

    public function getSession(): ?RouteSession
    {
        return $this->session;
    }

    public function setSession(RouteSession $session): self
    {
        $this->session = $session;
        return $this;
    }

    public function getEnergy(): ?int
    {
        return $this->energy;
    }

    public function setEnergy(int $energy): self
    {
        if ($energy < 1 || $energy > 5) {
            throw new \InvalidArgumentException('Energy must be between 1 and 5');
        }
        $this->energy = $energy;
        return $this;
    }

    public function getStress(): ?int
    {
        return $this->stress;
    }

    public function setStress(int $stress): self
    {
        if ($stress < 1 || $stress > 5) {
            throw new \InvalidArgumentException('Stress must be between 1 and 5');
        }
        $this->stress = $stress;
        return $this;
    }

    public function getMood(): ?int
    {
        return $this->mood;
    }

    public function setMood(int $mood): self
    {
        if ($mood < 1 || $mood > 5) {
            throw new \InvalidArgumentException('Mood must be between 1 and 5');
        }
        $this->mood = $mood;
        return $this;
    }

    public function getNotes(): ?string
    {
        return $this->notes;
    }

    public function setNotes(?string $notes): self
    {
        $this->notes = $notes;
        return $this;
    }

    public function getCreateAt(): ?\DateTimeInterface
    {
        return $this->createAt;
    }

    public function setCreateAt(\DateTimeInterface $createAt): self
    {
        $this->createAt = $createAt;
        return $this;
    }
}
