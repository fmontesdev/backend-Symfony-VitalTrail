<?php

declare(strict_types=1);

namespace App\Stats\Presentation\InputAdapter\Resource;

use App\Stats\Application\Config\StatsConfig;
use App\Stats\Presentation\InputAdapter\Provider\StatsProvider;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Estadísticas públicas de la plataforma para la página de inicio.
 *
 * CACHÉ HTTP (86400 s = 24 horas)
 * --------------------------------
 * Esta operación emite la cabecera:
 *   Cache-Control: max-age=86400, public, s-maxage=86400
 *
 * - max_age (86400):
 *     El navegador de cada usuario guarda la respuesta en su caché local
 *     durante 24 horas. Durante ese tiempo no realiza ninguna petición de
 *     red; sirve el dato directamente desde memoria.
 *
 * - shared_max_age (86400):
 *     Indica a cualquier caché compartida situada entre el cliente y el
 *     servidor (CDN, Varnish, Nginx proxy_cache…) que puede almacenar y
 *     servir esta respuesta durante 24 horas para TODOS los usuarios.
 *     Mientras la entrada esté vigente, ni PHP ni la base de datos reciben
 *     la petición.
 *
 * - public:
 *     Autoriza explícitamente a cachés compartidas (no solo al navegador)
 *     a almacenar la respuesta. Necesario porque el endpoint no requiere
 *     autenticación y el dato es el mismo para cualquier visitante.
 *
 * INVALIDACIÓN MANUAL
 * -------------------
 * Esta caché es HTTP, independiente de `php bin/console cache:clear`.
 * Para forzar la actualización antes de que expiren las 24 horas:
 *   - Navegador: recarga forzada (Ctrl+Shift+R / Cmd+Shift+R).
 *   - CDN/proxy: purga manual desde el panel o vía API del proveedor.
 *
 * JUSTIFICACIÓN
 * -------------
 * Los datos (totales de rutas, categorías, usuarios, km) cambian con poca
 * frecuencia y no requieren tiempo real para el home. La caché de 24 horas
 * elimina 4 consultas a la base de datos por cada visita, reduciendo la
 * carga del servidor sin impacto perceptible en la experiencia de usuario.
 */
#[ApiResource(
    operations: [
        new GetCollection(
            uriTemplate: '/stats/home',
            paginationEnabled: false,
            provider: StatsProvider::class,
            normalizationContext: [
                'groups' => [StatsConfig::OUTPUT],
            ],
            cacheHeaders: [
                'max_age' => 86400,
                'shared_max_age' => 86400,
                'public' => true,
            ],
        ),
    ],
)]
final class StatsResource
{
    #[Groups([StatsConfig::OUTPUT])]
    public int $totalRoutes = 0;

    #[Groups([StatsConfig::OUTPUT])]
    public int $totalCategories = 0;

    #[Groups([StatsConfig::OUTPUT])]
    public int $totalActiveUsers = 0;

    #[Groups([StatsConfig::OUTPUT])]
    public int $totalKm = 0;
}
