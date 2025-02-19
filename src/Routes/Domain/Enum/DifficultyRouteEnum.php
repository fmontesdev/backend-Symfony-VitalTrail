<?php

namespace App\Routes\Domain\Enum;

enum DifficultyRouteEnum: string
{
    case FACIL = 'fácil';
    case MODERADA = 'moderada';
    case DIFICIL = 'difícil';
    case EXPERTO = 'experto';
}
