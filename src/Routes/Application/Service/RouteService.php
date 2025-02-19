<?php

declare(strict_types=1);

namespace App\Routes\Application\Service;

use App\Routes\Domain\Entity\Route;
use App\Auth\Domain\Entity\User;
use App\Routes\Application\Dto\RouteDto;
use App\Routes\Presentation\Mapper\RouteMapper;
use App\Routes\Domain\OutputPort\RouteRepository;
use App\Security\Application\SecurityContext;
use App\Security\Application\AuthorizationService;
use App\Routes\Application\Exception\RouteNotFoundException;

class RouteService
{
    public function __construct(
        private readonly RouteRepository $routeRepository,
        private readonly SecurityContext $securityContext,
        private readonly AuthorizationService $authorizationService,
        private readonly RouteMapper $routeMapper
    ) {
    }

    public function getContextUser(): User
    {
        return $this->securityContext->getAuthenticatedUser();
    }

    public function findRouteSafe(string $slug): ?Route
    {
        $route = $this->routeRepository->findBySlug($slug);
        if ($route === null) {
            throw new RouteNotFoundException($slug );
        }
        return $route;
    }

    public function isAuthorized(Route $route): bool
    {
        return $this->authorizationService->isOwner($route) || $this->securityContext->isAdmin() ? true : false;
    }

    public function save(RouteDto $data, ?Route $route = null, ?User $user = null): Route
    {
        if ($user !== null) {
            $data->user = $user;
        }
        
        $result = $this->routeMapper->mapDtoToEntity($data, $route);
        $this->routeRepository->save($result);
        return $result;
    }

    public function toDto(Route $route, string $response = null): RouteDto
    {
        return $this->routeMapper->mapEntityToDto($route, $response);
    }
}