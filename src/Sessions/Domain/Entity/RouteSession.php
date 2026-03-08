<?php

declare(strict_types=1);

namespace App\Sessions\Domain\Entity;

use App\Auth\Domain\Entity\User;
use App\Routes\Domain\Entity\Route;
use App\Sessions\Infra\OutputAdapter\Doctrine\RouteSessionRepositoryImpl;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RouteSessionRepositoryImpl::class)]
#[ORM\Table(name: 'route_sessions')]
#[ORM\HasLifecycleCallbacks]
class RouteSession
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'id_session', type: Types::BIGINT)]
    private ?int $idSession = null;

    #[ORM\ManyToOne(inversedBy: 'routeSessions', targetEntity: User::class, fetch: 'LAZY')]
    #[ORM\JoinColumn(name: 'id_user', referencedColumnName: 'id_user', nullable: false, onDelete: 'CASCADE')]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'routeSessions', targetEntity: Route::class, fetch: 'LAZY')]
    #[ORM\JoinColumn(name: 'id_route', referencedColumnName: 'id_route', nullable: false, onDelete: 'CASCADE')]
    private ?Route $route = null;

    #[ORM\Column(name: 'start_at', type: Types::DATETIME_MUTABLE, options: ['default' => 'CURRENT_TIMESTAMP'])]
    private ?\DateTimeInterface $startAt = null;

    #[ORM\Column(name: 'end_at', type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $endAt = null;

    #[ORM\Column(name: 'create_at', type: Types::DATETIME_MUTABLE, options: ['default' => 'CURRENT_TIMESTAMP'])]
    private ?\DateTimeInterface $createAt = null;

    #[ORM\OneToOne(mappedBy: 'session', targetEntity: WellbeingCheckin::class, cascade: ['persist', 'remove'], fetch: 'LAZY')]
    private ?WellbeingCheckin $wellbeingCheckin = null;

    #[ORM\PrePersist]
    public function setTimestampsOnCreate(): void
    {
        if ($this->startAt === null) {
            $this->startAt = new \DateTimeImmutable();
        }
        $this->createAt = new \DateTimeImmutable();
    }

    public function getIdSession(): ?int
    {
        return $this->idSession;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;
        return $this;
    }

    public function getRoute(): ?Route
    {
        return $this->route;
    }

    public function setRoute(Route $route): self
    {
        $this->route = $route;
        return $this;
    }

    public function getStartAt(): ?\DateTimeInterface
    {
        return $this->startAt;
    }

    public function setStartAt(\DateTimeInterface $startAt): self
    {
        $this->startAt = $startAt;
        return $this;
    }

    public function getEndAt(): ?\DateTimeInterface
    {
        return $this->endAt;
    }

    public function setEndAt(?\DateTimeInterface $endAt): self
    {
        $this->endAt = $endAt;
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

    public function getWellbeingCheckin(): ?WellbeingCheckin
    {
        return $this->wellbeingCheckin;
    }

    public function setWellbeingCheckin(?WellbeingCheckin $wellbeingCheckin): self
    {
        $this->wellbeingCheckin = $wellbeingCheckin;
        return $this;
    }
}
