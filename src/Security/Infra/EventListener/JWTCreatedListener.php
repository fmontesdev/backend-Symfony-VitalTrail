<?php

declare(strict_types=1);

namespace App\Security\Infra\EventListener;

use App\Auth\Domain\Entity\User;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;
use Symfony\Component\HttpFoundation\RequestStack;

class JWTCreatedListener
{
    private RequestStack $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    public function onJWTCreated(JWTCreatedEvent $event): void
    {
        $payload = $event->getData();
        $user = $event->getUser();

        // Añadir datos personalizados al payload
        if ($user instanceof User) {
            // Ejemplo: añadir el ID de usuario en formato UUID
            $payload['sub'] = $user->getIdUser()->toRfc4122();
            $payload['email'] = $user->getEmail();
        }

        $event->setData($payload);
    }
}