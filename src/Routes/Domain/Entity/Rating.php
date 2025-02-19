<?php

declare(strict_types=1);

namespace App\Routes\Domain\Entity;

use App\Routes\Domain\Repository\RatingRepository;
use App\Auth\Domain\Entity\User;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RatingRepository::class)]
#[ORM\Table(name: 'ratings')]
#[ORM\HasLifecycleCallbacks]
class Rating
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'id_rating', type: Types::BIGINT)]
    private ?int $idRating = null;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: 'id_user', referencedColumnName: 'id_user', onDelete: 'CASCADE')]
    private ?User $user = null;

    #[ORM\ManyToOne(targetEntity: Route::class)]
    #[ORM\JoinColumn(name: 'id_route', referencedColumnName: 'id_route', onDelete: 'CASCADE')]
    private ?Route $route = null;

    // Relación 1:1 -> "Rating" es el lado propietario (owning side), ya que la tabla "ratings" tiene la FK a "comment".
    #[ORM\OneToOne(inversedBy: 'rating', targetEntity: Comment::class, cascade: ['persist'], fetch: 'LAZY')]
    #[ORM\JoinColumn(name: 'id_comment', referencedColumnName: 'id_comment', unique: true, onDelete: 'CASCADE', nullable: true)]
    private ?Comment $comment = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $rating = null;

    #[ORM\Column(name: 'create_at', type: Types::DATETIME_MUTABLE, options: ['default' => 'CURRENT_TIMESTAMP'])]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\PrePersist] // Se ejecuta antes de que la entidad se guarde por primera vez
    public function setTimestampsOnCreate(): void
    {
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getIdRating(): ?int
    {
        return $this->idRating;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;
        return $this;
    }

    public function getRoute(): Route
    {
        return $this->route;
    }

    public function setRoute(Route $route): self
    {
        $this->route = $route;
        return $this;
    }

    public function getComment(): ?Comment
    {
        return $this->comment;
    }

    public function setComment(?Comment $comment): self
    {
        $this->comment = $comment;
        return $this;
    }

    public function getRating(): int
    {
        return $this->rating;
    }

    public function setRating(int $rating): self
    {
        if ($rating < 1 || $rating > 5) {
            throw new \InvalidArgumentException('Rating must be between 1 and 5');
        }
        $this->rating = $rating;
        return $this;
    }

    public function getCreatedAt(): \DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
    }
};