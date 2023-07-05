<?php

declare(strict_types=1);

namespace App\Domain\Pokemon\Enum;

enum PokemonTypeEnum: string
{
    case NORMAL = 'Normal';
    case FIRE = 'Fire';
    case WATER = 'Water';
    case GRASS = 'Grass';
    case ELECTRIC = 'Electric';
    case ICE = 'Ice';
    case FIGHTING = 'Fighting';
    case POISON = 'Poison';
    case GROUND = 'Ground';
    case FLYING = 'Flying';
    case PSYCHIC = 'Psychic';
    case BUG = 'Bug';
    case ROCK = 'Rock';
    case GHOST = 'Ghost';
    case DARK = 'Dark';
    case DRAGON = 'Dragon';
    case STEEL = 'Steel';
    case FAIRY = 'Fairy';
}
