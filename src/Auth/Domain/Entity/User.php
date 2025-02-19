<?php

declare(strict_types=1);

namespace App\Auth\Domain\Entity;

use App\Auth\Domain\Enum\RolUserEnum;
use App\Auth\Application\Config\UserConfig;
use App\Auth\Infra\OutputAdapter\Doctrine\UserRepositoryImpl;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Uid\Uuid;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use App\Routes\Domain\Entity\Route;

#[ORM\Entity(repositoryClass: UserRepositoryImpl::class)]
#[ORM\Table(name: 'users')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\Column(name: 'id_user', type: 'uuid',  unique: true)]
    private ?Uuid $idUser = null;

    #[ORM\Column(length: UserConfig::EMAIL_LENGTH, unique: true)]
    private ?string $email = null;

    #[ORM\Column(length: UserConfig::USERNAME_LENGTH, unique: true)]
    private ?string $username = null;

    /**
     * @var string The hashed password
     */
    #[ORM\Column(length: 255)]
    private ?string $password = null;

    #[ORM\Column(length: UserConfig::NAME_LENGTH)]
    private ?string $name = null;

    #[ORM\Column(length: UserConfig::SURNAME_LENGTH)]
    private ?string $surname = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $birthday = null;

    #[ORM\Column(length: UserConfig::BIO_LENGTH, nullable: true)]
    private ?string $bio = null;

    #[ORM\Column(name: 'img_user', length: UserConfig::IMAGE_LENGTH, nullable: true)]
    private ?string $imgUser = null;

    #[ORM\Column(enumType: RolUserEnum::class)]
    private ?RolUserEnum $rol = null;

    #[ORM\Column(name: 'is_active', type: Types::BOOLEAN, options: ['default' => false])]
    private bool $isActive = false;

    #[ORM\Column(name: 'is_deleted', type: Types::BOOLEAN, options: ['default' => false])]
    private bool $isDeleted = false;

    #[ORM\Column(name: 'is_premium', type: Types::BOOLEAN, options: ['default' => false])]
    private bool $isPremium = false;

    // Relaciones 1:1 con Admin / Client. Relación inversa en "User" (mappedBy) y la relación propietaria en Admin / Client //

    #[ORM\OneToOne(mappedBy: 'user', targetEntity: Admin::class, cascade: ['persist', 'remove'], fetch: 'LAZY')]
    private ?Admin $admin = null;

    #[ORM\OneToOne(mappedBy: 'user', targetEntity: Client::class, cascade: ['persist', 'remove'], fetch: 'LAZY')]
    private ?Client $client = null;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Route::class, orphanRemoval: true, fetch: 'LAZY')]
    private Collection $routes;

    public function __construct()
    {
        $this->idUser = Uuid::v4(); // Genera un UUID al crear la entidad
        $this->routes = new ArrayCollection();
    }

    public function getIdUser(): Uuid
    {
        return $this->idUser;
    }

    public function setIdUser(Uuid $idUser): self
    {
        $this->idUser = $idUser;
        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;
        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getSurname(): string
    {
        return $this->surname;
    }

    public function setSurname(string $surname): self
    {
        $this->surname = $surname;
        return $this;
    }

    public function getBirthday(): ?\DateTimeInterface
    {
        return $this->birthday;
    }

    public function setBirthday(?\DateTimeInterface $birthday): self
    {
        $this->birthday = $birthday;
        return $this;
    }

    public function getBio(): ?string
    {
        return $this->bio;
    }

    public function setBio(?string $bio): self
    {
        $this->bio = $bio;
        return $this;
    }

    public function getImgUser(): ?string
    {
        return $this->imgUser;
    }

    public function setImgUser(?string $imgUser): self
    {
        $this->imgUser = $imgUser;
        return $this;
    }

    public function getRol(): RolUserEnum
    {
        return $this->rol;
    }

    public function setRol(RolUserEnum $rol): self
    {
        $this->rol = $rol;
        return $this;
    }

    public function getIsActive(): bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;
        return $this;
    }

    public function getIsDeleted(): bool
    {
        return $this->isDeleted;
    }

    public function setIsDeleted(bool $isDeleted): self
    {
        $this->isDeleted = $isDeleted;
        return $this;
    }

    public function getIsPremium(): bool
    {
        return $this->isPremium;
    }

    public function setIsPremium(bool $isPremium): self
    {
        $this->isPremium = $isPremium;
        return $this;
    }

    public function getAdmin(): ?Admin
    {
        return $this->admin;
    }

    public function setAdmin(?Admin $admin): self
    {
        $this->admin = $admin;
        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }  
    
    public function setClient(?Client $client): self
    {
        $this->client = $client;
        return $this;
    }

    //! =============== Rutas Revisar =============== //

    public function getRoutes(): Collection
    {
        return $this->routes;
    }

    public function addRoute(Route $route): self
    {
        if (!$this->routes->contains($route)) {
            $this->routes->add($route);
            // $route->setUser($this);
        }
        return $this;
    }

    public function removeRoute(Route $route): self
    {
        $this->routes->removeElement($route);
        return $this;

        // if ($this->routes->removeElement($route)) {
        //     if ($route->getUser() === $this) {
        //         $route->setUser(null);
        //     }
        // }
        // return $this;
    }

    // =============== Métodos de UserInterface =============== //

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->username;
    }

    /**
     * @see UserInterface
     * @return string[]
     */
    public function getRoles(): array
    {
        return [$this->rol->value]; // Convertir el enum a string
    }

    /**
     * @param string[] $roles
     * @return self
     */
    public function setRoles(array $roles): self
    {
        if (!empty($roles)) {
            $this->rol->value = $roles[0];
        }
        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }
}
