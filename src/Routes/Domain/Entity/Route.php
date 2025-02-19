<?php

declare(strict_types=1);

namespace App\Routes\Domain\Entity;

use App\Auth\Domain\Entity\User;
use App\Routes\Domain\Entity\CategoryRoute;
use App\Routes\Domain\Enum\DifficultyRouteEnum;
use App\Routes\Domain\Enum\TypeRouteEnum;
use App\Routes\Application\Config\RouteConfig;
use App\Routes\Domain\Repository\RouteRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Cocur\Slugify\Slugify;

#[ORM\Entity(repositoryClass: RouteRepository::class)]
#[ORM\Table(name: 'routes')]
#[ORM\HasLifecycleCallbacks] // Para que se activen los eventos del ciclo de vida de las entidades (PrePersist, PreUpdate, PostPersist, PostUpdate, PostRemove, PostLoad)
class Route
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'id_route', type: Types::BIGINT)]
    private ?int $idRoute = null;

    #[ORM\ManyToOne(inversedBy: 'routes', targetEntity: User::class, fetch: 'LAZY')]
    #[ORM\JoinColumn(name: 'id_user', referencedColumnName: 'id_user', nullable: false, onDelete: 'CASCADE')]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'routes', targetEntity: CategoryRoute::class, fetch: 'LAZY')]
    #[ORM\JoinColumn(name: 'id_category', referencedColumnName: 'id_category', nullable: false, onDelete: 'CASCADE')]
    private ?CategoryRoute $category = null;

    #[ORM\Column(length: RouteConfig::TITLE_LENGTH)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(length: RouteConfig::LOCATION_LENGTH)]
    private ?string $location = null;

    #[ORM\Column(type: Types::INTEGER)]
    private ?int $distance = null;

    #[ORM\Column(type: Types::INTEGER)]
    private ?int $duration = null;

    #[ORM\Column(enumType: DifficultyRouteEnum::class)]
    private ?DifficultyRouteEnum $difficulty = null;

    #[ORM\Column(name: 'type_route', enumType: TypeRouteEnum::class)]
    private ?TypeRouteEnum $typeRoute = null;

    // Se mapea JSONB como un array (json) para Doctrine
    #[ORM\Column(type: Types::JSON)]
    private ?array $coordinates = [];

    #[ORM\Column(name: 'create_at', type: Types::DATETIME_MUTABLE, options: ['default' => 'CURRENT_TIMESTAMP'])]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\Column(name: 'update_at', type: Types::DATETIME_MUTABLE, options: ['default' => 'CURRENT_TIMESTAMP'])]
    private ?\DateTimeInterface $updatedAt = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $start = null;

    #[ORM\Column(length: RouteConfig::SLUG_LENGTH, unique: true)]
    private ?string $slug = null;

    #[ORM\OneToMany(mappedBy: 'route', targetEntity: ImageRoute::class, fetch: 'LAZY')]
    private Collection $images;

    #[ORM\OneToMany(mappedBy: 'route', targetEntity: Comment::class, fetch: 'LAZY')]
    private Collection $comments;

    #[ORM\OneToMany(mappedBy: 'route', targetEntity: Rating::class, fetch: 'LAZY')]
    private Collection $ratings;

    private $originalTitle;

    public function __construct()
    {
        $this->images = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->ratings = new ArrayCollection();
    }

    #[ORM\PrePersist] // Se ejecuta antes de que la entidad se guarde por primera vez
    public function setTimestampsOnCreate(): void
    {
        $this->createdAt = new \DateTimeImmutable();
        $this->updatedAt = new \DateTimeImmutable();
    }

    #[ORM\PreUpdate] // Se ejecuta antes de actualizar la entidad
    public function setTimestampsOnUpdate(): void
    {
        $this->updatedAt = new \DateTimeImmutable();
    }

    #[ORM\PostLoad]
    public function storeOriginalTitle(): void
    {
        $this->originalTitle = $this->title;
    }

    #[ORM\PrePersist]
    #[ORM\PreUpdate]
    public function generateSlug(): void
    {
        // dump('Modificado ' . $this->title);
        if ($this->title === $this->originalTitle) return;
        $slugify = new Slugify();
        $baseSlug = $slugify->slugify($this->title); // Genera el slug base
        $hash = substr(sha1($this->title . $this->user->getIdUser() . uniqid('', true)), 0, 8); // Genera hash único
        $this->slug = $baseSlug . '-' . $hash; // Concatena el slug base con el hash
    }

    public function getIdRoute(): ?int
    {
        return $this->idRoute;
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

    public function getCategory(): ?CategoryRoute
    {
        return $this->category;
    }

    public function setCategory(CategoryRoute $category): self
    {
        $this->category = $category;
        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(string $location): self
    {
        $this->location = $location;
        return $this;
    }

    public function getDistance(): ?int
    {
        return $this->distance;
    }

    public function setDistance(int $distance): self
    {
        $this->distance = $distance;
        return $this;
    }

    /**
     * Formatea la duración como "HH:mm"
     */
    public function getDuration(): string
    {
        $hours = intdiv($this->duration, 60);
        $minutes = $this->duration % 60;
        return sprintf('%02d:%02d', $hours, $minutes);
    }

    public function setDuration(int $duration): self
    {
        $this->duration = $duration;
        return $this;
    }

    public function getDifficulty(): ?DifficultyRouteEnum
    {
        return $this->difficulty;
    }

    public function setDifficulty(DifficultyRouteEnum $difficulty): self
    {
        $this->difficulty = $difficulty;
        return $this;
    }

    public function getTypeRoute(): ?TypeRouteEnum
    {
        return $this->typeRoute;
    }

    public function setTypeRoute(TypeRouteEnum $typeRoute): self
    {
        $this->typeRoute = $typeRoute;
        return $this;
    }

    public function getCoordinates(): ?array
    {
        return $this->coordinates;
    }

    public function setCoordinates(array $coordinates): self
    {
        $this->coordinates = $coordinates;
        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    public function getStart(): ?\DateTimeInterface
    {
        return $this->start;
    }

    public function setStart(?\DateTimeInterface $start): self
    {
        $this->start = $start;
        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(?string $slug): self
    {
        $this->slug = $slug;
        return $this;
    }

    /**
     * @return Collection<int, ImageRoute>
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(ImageRoute $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images->add($image);
            // $image->setRoute($this);
        }
        return $this;
    }

    public function removeImage(ImageRoute $image): self
    {
        $this->images->removeElement($image);
        return $this;
    }

    /**
     * @return Collection<int, Comment>
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments->add($comment);
            // $comment->setRoute($this);
        }
        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        $this->comments->removeElement($comment);
        return $this;
    }

    /**
     * @return Collection<int, Rating>
     */
    public function getRatings(): Collection
    {
        return $this->ratings;
    }

    public function addRating(Rating $rating): self
    {
        if (!$this->ratings->contains($rating)) {
            $this->ratings->add($rating);
            // $rating->setRoute($this);
        }
        return $this;
    }

    public function removeRating(Rating $rating): self
    {
        $this->ratings->removeElement($rating);
        return $this;
    }
}
