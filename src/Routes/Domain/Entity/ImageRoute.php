<?php

declare(strict_types=1);

namespace App\Routes\Domain\Entity;

use App\Routes\Domain\Repository\ImageRouteRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Routes\Application\Config\ImageRouteConfig;

#[ORM\Entity(repositoryClass: ImageRouteRepository::class)]
#[ORM\Table(name: 'images_routes')]
class ImageRoute
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'id_img', type: Types::BIGINT)]
    private ?int $idImg = null;

    #[ORM\ManyToOne(inversedBy: 'images', targetEntity: Route::class)]
    #[ORM\JoinColumn(name: 'id_route', referencedColumnName: 'id_route', onDelete: 'CASCADE')]
    private ?Route $route = null;

    #[ORM\Column(name: 'img_route', length: ImageRouteConfig::IMG_ROUTE_LENGTH)]
    private ?string $imgRoute = null;

    public function getIdImg(): ?int
    {
        return $this->idImg;
    }

    public function getRoute(): Route
    {
        return $this->route;
    }

    public function setRoute(Route $route): void
    {
        $this->route = $route;
    }

    public function getImgRoute(): string
    {
        return $this->imgRoute;
    }

    public function setImgRoute(string $imgRoute): void
    {
        $this->imgRoute = $imgRoute;
    }
}
