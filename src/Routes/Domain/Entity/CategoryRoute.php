<?php

declare(strict_types=1);

namespace App\Routes\Domain\Entity;

use App\Routes\Application\Config\CategoryRouteConfig;
use App\Routes\Domain\Repository\CategoryRouteRepository;
use App\Routes\Domain\Entity\Route;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity(repositoryClass: CategoryRouteRepository::class)]
#[ORM\Table(name: 'categories_routes')]
#[ORM\HasLifecycleCallbacks]
class CategoryRoute
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'id_category', type: Types::BIGINT)]
    private ?int $idCategory = null;

    #[ORM\Column(length: CategoryRouteConfig::TITLE_LENGTH)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(name: 'img_category', length: CategoryRouteConfig::IMG_CATEGORY_LENGTH)]
    private ?string $imgCategory = null;

    #[ORM\OneToMany(mappedBy: 'category', targetEntity: Route::class, fetch: 'LAZY')]
    private Collection $routes;

    public function __construct()
    {
        $this->routes = new ArrayCollection();
    }

    public function getIdCategory(): ?int
    {
        return $this->idCategory;
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

    public function getImgCategory(): ?string
    {
        return $this->imgCategory;
    }

    public function setImgCategory(string $imgCategory): self
    {
        $this->imgCategory = $imgCategory;
        return $this;
    }

    /**
     * @return Collection<int, Route>
     */
    public function getRoutes(): Collection
    {
        return $this->routes;
    }

    public function addRoute(Route $route): self
    {
        if (!$this->routes->contains($route)) {
            $this->routes->add($route);
        }
        return $this;
    }

    public function removeRoute(Route $route): self
    {
        $this->routes->removeElement($route);
        return $this;
    }
}
