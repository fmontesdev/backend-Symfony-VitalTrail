<?php

declare(strict_types=1);

namespace App\Routes\Domain\Entity;

use App\Routes\Domain\Repository\FavoriteRepository;
use App\Auth\Domain\Entity\User;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FavoriteRepository::class)]
#[ORM\Table(name: 'favorites')]
class Favorite
{
    #[ORM\Id]
    #[ORM\ManyToOne(targetEntity: Route::class)]
    #[ORM\JoinColumn(name: 'id_route', referencedColumnName: 'id_route', onDelete: 'CASCADE')]
    private ?Route $route = null;

    #[ORM\Id]
    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: 'id_user', referencedColumnName: 'id_user', onDelete: 'CASCADE')]
    private ?User $user = null;

    public function getRoute(): Route
    {
        return $this->route;
    }

    public function setRoute(Route $route): void
    {
        $this->route = $route;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): void
    {
        $this->user = $user;
    }
}
