<?php

declare(strict_types=1);

namespace App\Security\Infra\Authenticator;

use Lexik\Bundle\JWTAuthenticationBundle\Exception\ExpiredTokenException;
use Lexik\Bundle\JWTAuthenticationBundle\Exception\InvalidTokenException;
use Lexik\Bundle\JWTAuthenticationBundle\Security\Authenticator\JWTAuthenticator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AuthenticationException;

/**
 * Decorador del JWTAuthenticator que trata los tokens JWT caducados o inválidos
 * como peticiones anónimas en lugar de devolver 401 inmediatamente.
 *
 * Problema que resuelve: cuando una petición incluye un token JWT caducado o inválido
 * dirigida a un endpoint con PUBLIC_ACCESS, el JWTAuthenticator base devuelve 401
 * antes de que se evalúen las reglas de access_control, impidiendo el acceso público.
 *
 * Solución: al devolver null en onAuthenticationFailure(), Symfony Security trata
 * al usuario como anónimo y evalúa las reglas de access_control normalmente.
 * Las rutas protegidas (IS_AUTHENTICATED_FULLY) siguen devolviendo 401 a través
 * del entry_point configurado.
 */
final class PublicAwareJwtAuthenticator extends JWTAuthenticator
{
    /**
     * Devuelve null para tokens caducados o inválidos en lugar de la respuesta 401
     * por defecto. Al devolver null, Symfony Security trata al usuario como anónimo
     * y las reglas de access_control se evalúan con normalidad.
     */
    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        if ($exception instanceof ExpiredTokenException || $exception instanceof InvalidTokenException) {
            return null;
        }

        return parent::onAuthenticationFailure($request, $exception);
    }
}
