<?php

declare(strict_types=1);

namespace App\Domain\Pokedex\Exception;

use App\Domain\Pokemon\Pokemon;

final class PokedexEntryAlreadyExistsForPokemonException extends \DomainException
{
    public function __construct(Pokemon $pokemon)
    {
        parent::__construct(
            sprintf(
                'Pokedex entry already exists for Pokemon %s.',
                (string) $pokemon->name(),
            ),
        );
    }
}
